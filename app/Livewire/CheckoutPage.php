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
    public ?string $comment = '';

    public array $shippingOptions = [];
    public array $npCities = [];
    public array $npWarehouses = [];

    public string $citySearchTerm = '';
    public bool $privacy_policy = false;

    public array $steps = [
        'personal_info' => 1,
        'delivery' => 2,
    ];

    protected $listeners = [
        'goBackStep' => 'goBackStep',
    ];

    /**
     * Инициализация компонента
     */
    public function mount(): void
    {
        // Получаем текущую корзину
        $this->cart = CartSession::current();
        if (!$this->cart) {
            Log::error('Корзина не найдена в сессии', [
                'session_id' => session()->getId(),
            ]);
            abort(404, 'Корзина не найдена.');
        }

        // Проверяем наличие связи shippingAddress
        $this->cart->load('shippingAddress'); // Подгружаем связь явно
        if (!$this->cart->shippingAddress) {
            try {
                // Проверяем, существует ли запись в таблице cart_addresses
                $existingAddress = CartAddress::where('cart_id', $this->cart->id)
                    ->where('type', 'shipping')
                    ->first();

                if (!$existingAddress) {
                    $address = $this->cart->addresses()->create([
                        'type' => 'shipping',
                        'country_id' => 1, // ID страны по умолчанию
                    ]);
                    Log::info('Создан новый адрес доставки', [
                        'cart_id' => $this->cart->id,
                        'address_id' => $address->id,
                    ]);
                } else {
                    $address = $existingAddress;
                }

                $this->cart->setShippingAddress($address);
                $this->shipping = $address;
            } catch (\Exception $e) {
                Log::error('Ошибка при создании адреса доставки', [
                    'cart_id' => $this->cart->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                abort(500, 'Не удалось инициализировать адрес доставки.');
            }
        } else {
            $this->shipping = $this->cart->shippingAddress;
        }

        // Проверяем, что $shipping является валидным экземпляром CartAddress
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Адрес доставки не является валидным экземпляром CartAddress', [
                'cart_id' => $this->cart->id,
                'shipping' => $this->shipping,
            ]);
            abort(500, 'Адрес доставки недействителен.');
        }

        $this->chosenShipping = $this->shipping->shipping_option ?? null;
        $this->cart->calculate();
        $this->loadShippingOptions();
        $this->currentStep = session('checkout_step', 1);

        // Дополнительное логирование для отладки первого шага
        Log::info('Инициализация компонента CheckoutPage', [
            'current_step' => $this->currentStep,
            'shipping_initialized' => $this->shipping instanceof \Lunar\Models\CartAddress,
            'shipping_data' => $this->shipping ? $this->shipping->toArray() : null,
        ]);

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
            'comment' => 'nullable|string|max:500',
        ];
    }

    /**
     * Загрузка вариантов доставки
     */
    public function loadShippingOptions(): void
    {
        if (!$this->cart instanceof \Lunar\Models\Cart) {
            Log::error('Корзина недействительна при загрузке вариантов доставки', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            return;
        }

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
        if (!$this->cart instanceof \Lunar\Models\Cart) {
            Log::error('Корзина недействительна при проверке цен', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            return;
        }

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
        if (!$this->cart instanceof \Lunar\Models\Cart) {
            Log::error('Корзина недействительна при обновлении количества товара', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            return;
        }

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
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Попытка сохранения адреса доставки с null значением', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            $this->addError('shipping', 'Адрес доставки недействителен.');
            return;
        }

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
     * Сохранение варианта доставки и оформление заказа
     */
    public function saveShippingOption(): void
    {
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Попытка сохранения варианта доставки с null адресом', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            $this->addError('shipping', 'Адрес доставки недействителен.');
            return;
        }

        $this->validate([
            'chosenShipping' => 'required|string',
            'shipping.city' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable',
            'shipping.line_one' => $this->chosenShipping === 'nova-poshta' ? 'required|string|max:255' : 'nullable|string|max:255',
            'comment' => 'nullable|string|max:500',
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

        // Устанавливаем billing address, копируя данные из shipping address
        $billingAddress = CartAddress::where('cart_id', $this->cart->id)
            ->where('type', 'billing')
            ->first();

        if (!$billingAddress) {
            $billingAddress = $this->cart->addresses()->create([
                'type' => 'billing',
                'country_id' => $this->shipping->country_id,
                'first_name' => $this->shipping->first_name,
                'last_name' => $this->shipping->last_name,
                'contact_phone' => $this->shipping->contact_phone,
                'contact_email' => $this->shipping->contact_email,
                'company' => $this->shipping->company,
                'city' => $this->shipping->city,
                'line_one' => $this->shipping->line_one,
            ]);
            Log::info('Создан новый адрес для выставления счета', [
                'cart_id' => $this->cart->id,
                'billing_address_id' => $billingAddress->id,
            ]);
        }

        $this->cart->setBillingAddress($billingAddress);
        $this->cart->shippingTotal = new \Lunar\DataTypes\Price(0, $this->cart->currency, 1);
        $this->cart->calculate();
        $this->loadShippingOptions();

        // Оформление заказа
        try {
            $order = $this->cart->createOrder();
            if ($this->comment) {
                $order->meta = array_merge($order->meta ?? [], ['comment' => $this->comment]);
                $order->save();
            }

            // Очистка корзины
            CartSession::forget();

            // Перенаправление на главную страницу
            $this->redirect('/');
        } catch (\Exception $e) {
            Log::error('Ошибка при создании заказа', [
                'cart_id' => $this->cart->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->addError('order', 'Не удалось создать заказ. Пожалуйста, попробуйте снова.');
        }
    }

    /**
     * Обновление поискового запроса для города
     */
    public function updatedCitySearchTerm(): void
    {
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Попытка обновления citySearchTerm с null адресом доставки', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            $this->addError('shipping', 'Адрес доставки недействителен.');
            return;
        }

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
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Попытка выбора города с null адресом доставки', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            $this->addError('shipping', 'Адрес доставки недействителен.');
            return;
        }

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
        if (!$this->shipping instanceof \Lunar\Models\CartAddress) {
            Log::error('Попытка обновления shipping.city с null адресом доставки', [
                'cart_id' => $this->cart ? $this->cart->id : null,
            ]);
            $this->addError('shipping', 'Адрес доставки недействителен.');
            return;
        }

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
        // Логирование для отладки рендеринга
        Log::info('Рендеринг CheckoutPage', [
            'current_step' => $this->currentStep,
            'shipping_exists' => $this->shipping instanceof \Lunar\Models\CartAddress,
            'cart_id' => $this->cart ? $this->cart->id : null,
        ]);

        return view('livewire.checkout-page', [
            'shippingOption' => $this->shippingOption,
            'steps' => $this->steps,
            'shippingOptions' => $this->shippingOptions,
            'npCities' => $this->npCities,
            'npWarehouses' => $this->npWarehouses,
        ])->layout('layouts.checkout');
    }
}
