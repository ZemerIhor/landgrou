<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Facades\ShippingManifest;
use Lunar\Models\Cart;
use Lunar\Models\CartAddress;
use Lunar\Models\Currency; // Добавляем для работы с валютой

class CheckoutPage extends Component
{
    public bool $linesVisible = false;
    public bool $showCityDropdown = true;

    public ?Cart $cart = null;
    public ?CartAddress $shipping = null;

    public int $currentStep = 1;
    public ?string $chosenShipping = null;

    public array $shippingOptions = [];
    public array $npCities = [];
    public array $npWarehouses = [];

    public string $citySearchTerm = '';

    public array $steps = [
        'personal_info' => 1,
        'delivery' => 2,
        'payment' => 3,
    ];

    protected $listeners = [
        'goBackStep' => 'goBackStep',
    ];

    public function mount(): void
    {
        $this->cart = CartSession::current() ?? abort(404);

        if (!$this->cart->shippingAddress) {
            $address = $this->cart->addresses()->create([
                'type' => 'shipping',
            ]);
            $this->cart->setShippingAddress($address);
            $this->shipping = $address;
        } else {
            $this->shipping = $this->cart->shippingAddress;
        }

        $this->chosenShipping = $this->shipping->shipping_option ?? null;
        $this->cart->calculate();
        $this->loadShippingOptions();
        $this->currentStep = session('checkout_step', 1);

        // Проверка цен товаров
        $this->validateCartPrices();
    }

    public function rules(): array
    {
        return [
            'shipping.first_name' => 'required|string|max:255',
            'shipping.last_name' => 'required|string|max:255',
            'shipping.contact_phone' => 'required|string|max:30',
            'shipping.contact_email' => 'required|email|max:255',
            'shipping.city' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable',
            'shipping.line_one' => $this->chosenShipping === 'nova-poshta' ? 'required|string|max:255' : 'nullable|string|max:255',
            'chosenShipping' => 'required|string',
        ];
    }

    public function loadShippingOptions(): void
    {
        $this->shippingOptions = ShippingManifest::getOptions($this->cart)->map(function ($option) {
            return [
                'name' => $option->name,
                'description' => $option->description,
                'identifier' => $option->identifier,
                'price' => 0, // Стоимость доставки всегда 0
                'formatted_price' => '0.00', // Не отображаем цену
                'collect' => $option->collect ?? false,
            ];
        })->toArray();
    }

    public function validateCartPrices(): void
    {
        foreach ($this->cart->lines as $line) {
            if ($line->subTotal->value <= 0) {
                Log::warning('Товар в корзине имеет нулевую цену', [
                    'product_id' => $line->purchasable_id,
                    'description' => $line->purchasable->getDescription(),
                    'subtotal' => $line->subTotal->value,
                ]);
                $this->addError('cart', 'Один или несколько товаров имеют нулевую цену. Пожалуйста, обновите цены в базе данных.');
            }
        }
    }

    public function saveAddress(): void
    {
        $this->validate([
            'shipping.first_name' => 'required|string|max:255',
            'shipping.last_name' => 'required|string|max:255',
            'shipping.contact_phone' => 'required|string|max:30',
            'shipping.contact_email' => 'required|email|max:255',
        ]);

        $this->shipping->save();

        $this->currentStep = $this->steps['delivery'];
        session(['checkout_step' => $this->currentStep]);
    }

    public function saveShippingOption(): void
    {
        $this->validate();

        $option = ShippingManifest::getOptions($this->cart)->first(
            fn($opt) => $opt->getIdentifier() === $this->chosenShipping
        );

        if (!$option) {
            throw new \Exception('Опция доставки не найдена.');
        }

        CartSession::setShippingOption($option);

        $this->shipping->shipping_option = $this->chosenShipping;
        $this->shipping->save();
        $this->cart->setShippingAddress($this->shipping);

        // Устанавливаем стоимость доставки как 0 без использования Money
        $this->cart->shippingTotal = 0;

        $this->cart->calculate();
        $this->loadShippingOptions();

        $this->currentStep = $this->steps['payment'];
        session(['checkout_step' => $this->currentStep]);
    }

    public function updatedCitySearchTerm(): void
    {
        $this->showCityDropdown = true;
        $this->shipping->line_one = '';
        $this->npWarehouses = [];

        if (strlen($this->citySearchTerm) < 2) {
            $this->npCities = [];
            $this->showCityDropdown = false;
            return;
        }

        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => '', // API-ключ не требуется
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'searchSettlements',
            'methodProperties' => [
                'CityName' => $this->citySearchTerm,
                'Limit' => '50',
                'Page' => '1',
            ],
        ]);

        Log::info('Запрос к API Новой Почты для городов', [
            'search_term' => $this->citySearchTerm,
            'response_status' => $response->status(),
            'response_body' => $response->json(),
        ]);

        if ($response->successful() && ($response->json('success') ?? false)) {
            $data = $response->json('data') ?? [];
            $this->npCities = collect($data)->flatMap(fn($item) =>
            isset($item['Addresses']) ? $item['Addresses'] : [$item]
            )->filter(fn($city) => isset($city['MainDescription']))->toArray();
        } else {
            Log::error('Nova Poshta: error fetching cities', [
                'search_term' => $this->citySearchTerm,
                'response' => $response->json(),
                'errors' => $response->json('errors') ?? 'Нет деталей ошибки',
            ]);
            $this->npCities = [];
            $this->showCityDropdown = false;
            $this->addError('shipping.city', 'Ошибка загрузки городов. Попробуйте еще раз.');
        }
    }

    public function selectCity($cityName): void
    {
        $this->shipping->city = $cityName;
        $this->citySearchTerm = $cityName;
        $this->showCityDropdown = false;
        $this->shipping->line_one = '';
        $this->npWarehouses = [];

        $city = collect($this->npCities)->first(fn($c) => ($c['MainDescription'] ?? '') === $cityName);

        if ($city && isset($city['DeliveryCity'])) {
            Log::info('Выбран город', [
                'city' => $cityName,
                'delivery_city' => $city['DeliveryCity'],
                'ref' => $city['Ref'],
                'city_data' => $city,
            ]);
            $this->fetchNovaPoshtaWarehouses($city['DeliveryCity']);
        } else {
            Log::error('DeliveryCity не найден для города', [
                'city' => $cityName,
                'available_cities' => $this->npCities,
            ]);
            $this->addError('shipping.city', 'Не удалось загрузить отделения для выбранного города.');
        }

        $this->cart->calculate();
        $this->loadShippingOptions();
    }

    public function updatedShippingCity($cityName): void
    {
        $this->shipping->line_one = '';
        $this->npWarehouses = [];

        $city = collect($this->npCities)->first(fn($c) => ($c['MainDescription'] ?? '') === $cityName);

        if ($city && isset($city['DeliveryCity'])) {
            Log::info('Обновлен город через updatedShippingCity', [
                'city' => $cityName,
                'delivery_city' => $city['DeliveryCity'],
                'ref' => $city['Ref'],
            ]);
            $this->fetchNovaPoshtaWarehouses($city['DeliveryCity']);
        } else {
            Log::error('DeliveryCity не найден для города в updatedShippingCity', [
                'city' => $cityName,
                'available_cities' => $this->npCities,
            ]);
        }

        $this->cart->calculate();
        $this->loadShippingOptions();
    }

    public function updatedChosenShipping(): void
    {
        if ($this->chosenShipping === 'nova-poshta' && $this->shipping->city) {
            $city = collect($this->npCities)->first(fn($c) => ($c['MainDescription'] ?? '') === $this->shipping->city);
            if ($city && isset($city['DeliveryCity'])) {
                $this->fetchNovaPoshtaWarehouses($city['DeliveryCity']);
            }
        } else {
            $this->npWarehouses = [];
            $this->shipping->city = '';
            $this->shipping->line_one = '';
        }

        $this->cart->calculate();
        $this->loadShippingOptions();
    }

    public function fetchNovaPoshtaWarehouses(string $cityRef): void
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => '', // API-ключ не требуется
            'modelName' => 'Address',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'CityRef' => $cityRef,
                'TypeOfWarehouseRef' => '841339c7-591a-42e2-8233-7a0a00f0ed6f', // Только почтовые отделения
                'Limit' => '100',
                'Page' => '1',
            ],
        ]);

        Log::info('Запрос к API Новой Почты для отделений', [
            'cityRef' => $cityRef,
            'response_status' => $response->status(),
            'response_body' => $response->json(),
            'errors' => $response->json('errors') ?? 'Нет деталей ошибки',
        ]);

        if ($response->successful() && ($response->json('success') ?? false)) {
            $this->npWarehouses = $response->json('data') ?? [];
            if (empty($this->npWarehouses)) {
                Log::warning('Список отделений пуст для города', ['cityRef' => $cityRef]);
                $this->addError('shipping.line_one', 'Не найдено отделений для выбранного города. Попробуйте другой город.');
            }
        } else {
            Log::error('Nova Poshta: error fetching warehouses', [
                'cityRef' => $cityRef,
                'response' => $response->json(),
                'errors' => $response->json('errors') ?? 'Нет деталей ошибки',
            ]);
            $this->npWarehouses = [];
            $this->addError('shipping.line_one', 'Ошибка загрузки отделений. Проверьте подключение или попробуйте позже.');
        }
    }

    public function goBackStep(): void
    {
        $this->currentStep = max(1, $this->currentStep - 1);
        session(['checkout_step' => $this->currentStep]);
    }

    public function getShippingOptionProperty()
    {
        return collect($this->shippingOptions)->firstWhere('identifier', $this->chosenShipping) ?? null;
    }

    public function render(): View
    {
        return view('livewire.checkout-page', [
            'shippingOption' => $this->shippingOption,
            'steps' => $this->steps,
            'shippingOptions' => $this->shippingOptions,
            'npCities' => $this->npCities,
            'npWarehouses' => $this->npWarehouses,
        ])->layout('layouts.checkout');
    }
}
