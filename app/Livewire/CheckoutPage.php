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
use Lunar\Models\Currency;

class CheckoutPage extends Component
{
    public bool $linesVisible = false;
    public bool $showCityDropdown = true;

    public ?Cart $cart = null;
    public ?CartAddress $shipping = null;

    public int $currentStep = 1;
    public ?string $chosenShipping = null;
    public ?string $paymentType = null;
    public ?string $comment = ''; // Поле для комментария к заказу

    public array $shippingOptions = [];
    public array $npCities = [];
    public array $npWarehouses = [];

    public string $citySearchTerm = '';
    public bool $privacy_policy = false;

    public array $steps = [
        'personal_info' => 1,
        'delivery' => 2,
        'payment' => 3,
    ];

    protected $listeners = [
        'goBackStep' => 'goBackStep',
    ];

    /**
     * Инициализация компонента
     */
    public function mount(): void
    {
        $this->cart = CartSession::current() ?? abort(404);

        // Проверяем наличие адреса доставки и создаем новый, если отсутствует
        if (!$this->cart->shippingAddress) {
            try {
                $address = $this->cart->addresses()->create([
                    'type' => 'shipping',
                ]);
                $this->cart->setShippingAddress($address);
                $this->shipping = $address;
            } catch (\Exception $e) {
                Log::error('Не удалось создать адрес доставки', [
                    'error' => $e->getMessage(),
                    'cart_id' => $this->cart->id,
                ]);
                abort(500, 'Не удалось инициализировать адрес доставки.');
            }
        } else {
            $this->shipping = $this->cart->shippingAddress;
        }

        // Проверяем, что $shipping является валидным экземпляром CartAddress
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Адрес доставки не является валидным экземпляром CartAddress', [
                'shipping' => $this->shipping,
                'cart_id' => $this->cart->id,
            ]);
            abort(500, 'Адрес доставки недействителен.');
        }

        $this->chosenShipping = $this->shipping->shipping_option ?? null;
        $this->cart->calculate();
        $this->loadShippingOptions();
        $this->currentStep = session('checkout_step', 1);

        // Логирование данных корзины
        Log::info('Данные корзины при оформлении заказа', [
            'subTotal' => $this->cart->subTotal instanceof \Lunar\DataTypes\Price
                ? ['value' => $this->cart->subTotal->value, 'formatted' => $this->cart->subTotal->formatted()]
                : $this->cart->subTotal,
            'total' => $this->cart->total instanceof \Lunar\DataTypes\Price
                ? ['value' => $this->cart->total->value, 'formatted' => $this->cart->total->formatted()]
                : $this->cart->total,
            'lines' => $this->cart->lines->map(fn($line) => [
                'id' => $line->id,
                'subTotal' => $line->subTotal instanceof \Lunar\DataTypes\Price
                    ? ['value' => $line->subTotal->value, 'formatted' => $line->subTotal->formatted()]
                    : $line->subTotal,
            ])->toArray(),
        ]);

        $this->validateCartPrices();
    }

    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'shipping.first_name' => 'required|string|max:255',
            'shipping.last_name' => 'required|string|max:255',
            'shipping.contact_phone' => 'required|string|max:30',
            'shipping.contact_email' => 'required|email|max:255',
            'shipping.company' => 'nullable|string|max:255',
            'privacy_policy' => 'accepted',
            'shipping.city' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable',
            'shipping.line_one' => $this->chosenShipping === 'nova-poshta' ? 'required|string|max:255' : 'nullable|string|max:255',
            'chosenShipping' => 'required|string',
            'paymentType' => 'required|string|in:card,cash-on-delivery',
            'comment' => 'nullable|string|max:500', // Валидация для комментария
        ];
    }

    /**
     * Загрузка вариантов доставки
     */
    public function loadShippingOptions(): void
    {
        $currency = Currency::where('code', $this->cart->currency->code)->first() ?? Currency::first();

        $this->shippingOptions = ShippingManifest::getOptions($this->cart)->map(function ($option) use ($currency) {
            return [
                'name' => $option->name,
                'description' => $option->description,
                'identifier' => $option->identifier,
                'price' => new \Lunar\DataTypes\Price($option->price->value ?? 0, $currency, 1),
                'formatted_price' => (new \Lunar\DataTypes\Price($option->price->value ?? 0, $currency, 1))->formatted(),
                'collect' => $option->collect ?? false,
            ];
        })->toArray();
    }

    /**
     * Проверка цен в корзине
     */
    public function validateCartPrices(): void
    {
        foreach ($this->cart->lines as $line) {
            if ($line->subTotal->value <= 0) {
                Log::warning('Товар в корзине имеет нулевую цену', [
                    'product_id' => $line->purchasable_id,
                    'description' => $line->purchasable->getDescription(),
                    'subtotal' => $line->subTotal->value,
                ]);
                $this->addError('cart', __('messages.checkout.zero_price_error'));
            }
        }
    }

    /**
     * Обновление количества товара в корзине
     */
    public function updateLineQuantity($lineId, $quantity): void
    {
        if ($quantity < 1) {
            $this->cart->lines()->where('id', $lineId)->delete();
        } else {
            $this->cart->lines()->where('id', $lineId)->update(['quantity' => $quantity]);
        }
        $this->cart->refresh();
        $this->cart->calculate();
    }

    /**
     * Сохранение адреса доставки
     */
    public function saveAddress(): void
    {
        $this->validate([
            'shipping.first_name' => 'required|string|max:255',
            'shipping.last_name' => 'required|string|max:255',
            'shipping.contact_phone' => 'required|string|max:30',
            'shipping.contact_email' => 'required|email|max:255',
            'shipping.company' => 'nullable|string|max:255',
            'privacy_policy' => 'accepted',
        ]);

        Log::info('Сохранение адреса доставки', ['shipping' => $this->shipping->toArray()]);
        $this->shipping->save();
        $this->currentStep = $this->steps['delivery'];
        session(['checkout_step' => $this->currentStep]);
    }

    /**
     * Сохранение варианта доставки
     */
    public function saveShippingOption(): void
    {
        $this->validate([
            'chosenShipping' => 'required|string',
            'shipping.city' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable',
            'shipping.line_one' => $this->chosenShipping === 'nova-poshta' ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        $option = ShippingManifest::getOptions($this->cart)->first(
            fn($opt) => $opt->getIdentifier() === $this->chosenShipping
        );

        if (!$option) {
            $this->addError('chosenShipping', __('messages.checkout.shipping_option_not_found'));
            return;
        }

        CartSession::setShippingOption($option);
        $this->shipping->shipping_option = $this->chosenShipping;
        $this->shipping->save();
        $this->cart->setShippingAddress($this->shipping);
        $this->cart->shippingTotal = new \Lunar\DataTypes\Price(0, $this->cart->currency, 1);
        $this->cart->calculate();
        $this->loadShippingOptions();

        $this->currentStep = $this->steps['payment'];
        session(['checkout_step' => $this->currentStep]);
    }

    /**
     * Завершение оформления заказа
     */
    public function checkout(): void
    {
        $this->validate([
            'paymentType' => 'required|string|in:card,cash-on-delivery',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($this->paymentType === 'cash-on-delivery') {
            $order = $this->cart->createOrder();
            // Сохранение комментария в мета-данных заказа
            if ($this->comment) {
                $order->meta = array_merge($order->meta ?? [], ['comment' => $this->comment]);
                $order->save();
            }
            $this->redirect(route('order.confirmation', $order->id));
        }
        // Добавить логику для оплаты картой, если требуется
    }

    /**
     * Обновление поискового запроса для города
     */
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
            'apiKey' => env('NOVA_POSHTA_API_KEY', ''),
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
            Log::error('Ошибка при получении городов от Новой Почты', [
                'search_term' => $this->citySearchTerm,
                'response' => $response->json(),
                'errors' => $response->json('errors') ?? 'Нет деталей ошибки',
            ]);
            $this->npCities = [];
            $this->showCityDropdown = false;
            $this->addError('shipping.city', __('messages.checkout.city_load_error'));
        }
    }

    /**
     * Выбор города
     */
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
            $this->addError('shipping.city', __('messages.checkout.warehouse_load_error'));
        }

        $this->cart->calculate();
        $this->loadShippingOptions();
    }

    /**
     * Обновление города доставки
     */
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

    /**
     * Получение отделений Новой Почты
     */
    public function fetchNovaPoshtaWarehouses(string $cityRef): void
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => env('NOVA_POSHTA_API_KEY', ''),
            'modelName' => 'Address',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'CityRef' => $cityRef,
                'TypeOfWarehouseRef' => '841339c7-591a-42e2-8233-7a0a00f0ed6f',
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
                $this->addError('shipping.line_one', __('messages.checkout.warehouse_empty_error'));
            }
        } else {
            Log::error('Ошибка при получении отделений Новой Почты', [
                'cityRef' => $cityRef,
                'response' => $response->json(),
                'errors' => $response->json('errors') ?? 'Нет деталей ошибки',
            ]);
            $this->npWarehouses = [];
            $this->addError('shipping.line_one', __('messages.checkout.warehouse_load_error'));
        }
    }

    /**
     * Получение текущего варианта доставки
     */
    public function getShippingOptionProperty()
    {
        return collect($this->shippingOptions)->firstWhere('identifier', $this->chosenShipping) ?? null;
    }

    /**
     * Возврат к предыдущему шагу
     */
    public function goBackStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            session(['checkout_step' => $this->currentStep]);
        }
    }

    /**
     * Рендеринг шаблона
     */
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
