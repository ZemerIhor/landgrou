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
use Lunar\DataTypes\Price;

class CheckoutPage extends Component
{
    public bool $linesVisible = false;
    public bool $showCityDropdown = true;

    public ?Cart $cart = null;

    public int $currentStep = 1;
    public ?string $chosenShipping = null;
    public ?string $comment = '';
    public bool $shippingIsBilling = true;

    public array $shippingOptions = [];
    public array $npCities = [];
    public array $npWarehouses = [];
    public array $shippingData = [];

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
        $this->initializeCartAndShipping();
        $this->chosenShipping = $this->cart->meta['shipping_option'] ?? ($this->cart->shippingAddress->meta['shipping_option'] ?? null);
        $this->shippingData = $this->cart->shippingAddress->getAttributes();
        $this->currentStep = session('checkout_step', 1);

        $this->cart->calculate();
        $this->loadShippingOptions();

        Log::info('Инициализация компонента CheckoutPage', [
            'current_step' => $this->currentStep,
            'shipping_initialized' => $this->cart->shippingAddress instanceof \Lunar\Models\CartAddress,
            'shipping_data' => $this->cart->shippingAddress ? $this->cart->shippingAddress->toArray() : null,
            'chosen_shipping' => $this->chosenShipping,
            'cart_meta' => $this->cart->meta ? $this->cart->meta->toArray() : null,
            'cart_lines' => $this->cart->lines->map(fn($line) => [
                'id' => $line->id,
                'subTotal' => $line->subTotal instanceof \Lunar\DataTypes\Price
                    ? ['value' => $line->subTotal->value, 'formatted' => $line->subTotal->formatted()]
                    : $line->subTotal,
            ])->toArray(),
        ]);

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
     * Гидратация компонента
     */
    public function hydrate(): void
    {
        $this->initializeCartAndShipping();
        $this->shippingData = $this->cart->shippingAddress->getAttributes();

        Log::info('Гидратация компонента CheckoutPage', [
            'current_step' => $this->currentStep,
            'shipping_initialized' => $this->cart->shippingAddress instanceof \Lunar\Models\CartAddress,
            'shipping_data' => $this->cart->shippingAddress ? $this->cart->shippingAddress->toArray() : null,
            'chosen_shipping' => $this->chosenShipping,
            'cart_meta' => $this->cart->meta ? $this->cart->meta->toArray() : null,
            'cart_lines' => $this->cart->lines->map(fn($line) => [
                'id' => $line->id,
                'subTotal' => $line->subTotal instanceof \Lunar\DataTypes\Price
                    ? ['value' => $line->subTotal->value, 'formatted' => $line->subTotal->formatted()]
                    : $line->subTotal,
            ])->toArray(),
        ]);
    }

    /**
     * Инициализация корзины и адреса доставки
     */
    protected function initializeCartAndShipping(): void
    {
        $this->cart = CartSession::current();
        if (!$this->cart) {
            Log::error('Корзина не найдена в сессии', [
                'session_id' => session()->getId(),
            ]);
            abort(404, 'Корзина не найдена.');
        }

        $this->cart->load('shippingAddress');
        if (!$this->cart->shippingAddress) {
            try {
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
            } catch (\Exception $e) {
                Log::error('Ошибка при создании адреса доставки', [
                    'cart_id' => $this->cart->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                abort(500, 'Не удалось инициализировать адрес доставки.');
            }
        }

        if (!$this->cart->shippingAddress instanceof \Lunar\Models\CartAddress) {
            Log::error('Адрес доставки не является валидным экземпляром CartAddress', [
                'cart_id' => $this->cart->id,
                'shipping' => $this->cart->shippingAddress,
            ]);
            abort(500, 'Адрес доставки недействителен.');
        }
    }

    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'shippingData.first_name' => 'required|string|max:255',
            'shippingData.last_name' => 'required|string|max:255',
            'shippingData.contact_phone' => 'required|string|max:30',
            'shippingData.contact_email' => 'required|email|max:255',
            'shippingData.company' => 'nullable|string|max:255',
            'privacy_policy' => 'accepted',
            'shippingData.city' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable|string|max:255',
            'shippingData.line_one' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable|string|max:255',
            'shippingData.postcode' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable|string|max:255',
            'chosenShipping' => 'required|string|in:pickup,nova-poshta,courier',
            'comment' => 'nullable|string|max:500',
            'shippingIsBilling' => 'boolean',
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

        $this->shippingOptions = ShippingManifest::getOptions($this->cart)->unique('identifier')->map(function ($option) use ($currency) {
            return [
                'name' => $option->name,
                'description' => $option->description,
                'identifier' => $option->identifier,
                'price' => new \Lunar\DataTypes\Price($option->price->value ?? 0, $currency, 1),
                'formatted_price' => (new \Lunar\DataTypes\Price($option->price->value ?? 0, $currency, 1))->formatted(),
                'collect' => $option->collect ?? false,
            ];
        })->toArray();

        Log::info('Опции доставки загружены', [
            'cart_id' => $this->cart->id,
            'options' => array_column($this->shippingOptions, 'identifier'),
        ]);
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
        $this->validate([
            'shippingData.first_name' => 'required|string|max:255',
            'shippingData.last_name' => 'required|string|max:255',
            'shippingData.contact_phone' => 'required|string|max:30',
            'shippingData.contact_email' => 'required|email|max:255',
            'shippingData.company' => 'nullable|string|max:255',
            'privacy_policy' => 'accepted',
            'shippingIsBilling' => 'boolean',
        ]);

        Log::info('Сохранение адреса доставки', ['shipping' => $this->shippingData]);

        $this->cart->shippingAddress->fill([
            'first_name' => $this->shippingData['first_name'],
            'last_name' => $this->shippingData['last_name'],
            'contact_phone' => $this->shippingData['contact_phone'],
            'contact_email' => $this->shippingData['contact_email'],
            'company' => $this->shippingData['company'] ?? null,
        ])->save();

        $this->cart->setShippingAddress($this->cart->shippingAddress);
        $this->cart->refresh();

        if ($this->shippingIsBilling) {
            $billingAddress = CartAddress::where('cart_id', $this->cart->id)
                ->where('type', 'billing')
                ->first();

            if (!$billingAddress) {
                $billingAddress = $this->cart->addresses()->create([
                    'type' => 'billing',
                    'country_id' => $this->cart->shippingAddress->country_id,
                    'first_name' => $this->shippingData['first_name'],
                    'last_name' => $this->shippingData['last_name'],
                    'contact_phone' => $this->shippingData['contact_phone'],
                    'contact_email' => $this->shippingData['contact_email'],
                    'company' => $this->shippingData['company'] ?? null,
                    'city' => $this->shippingData['city'] ?? 'Не требуется',
                    'line_one' => $this->shippingData['line_one'] ?? 'Самовывоз',
                    'postcode' => $this->shippingData['postcode'] ?? '00000',
                ]);
                Log::info('Создан новый адрес для выставления счета', [
                    'cart_id' => $this->cart->id,
                    'billing_address_id' => $billingAddress->id,
                ]);
            } else {
                $billingAddress->fill([
                    'country_id' => $this->cart->shippingAddress->country_id,
                    'first_name' => $this->shippingData['first_name'],
                    'last_name' => $this->shippingData['last_name'],
                    'contact_phone' => $this->shippingData['contact_phone'],
                    'contact_email' => $this->shippingData['contact_email'],
                    'company' => $this->shippingData['company'] ?? null,
                    'city' => $this->shippingData['city'] ?? 'Не требуется',
                    'line_one' => $this->shippingData['line_one'] ?? 'Самовывоз',
                    'postcode' => $this->shippingData['postcode'] ?? '00000',
                ])->save();
            }
            $this->cart->setBillingAddress($billingAddress);
            $this->cart->refresh();
        }

        $this->currentStep = $this->steps['delivery'];
        session(['checkout_step' => $this->currentStep]);
    }

    /**
     * Сохранение варианта доставки и оформление заказа
     */
    public function saveShippingOption(): void
    {
        $this->validate([
            'chosenShipping' => 'required|string|in:pickup,nova-poshta,courier',
            'shippingData.city' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable|string|max:255',
            'shippingData.line_one' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable|string|max:255',
            'shippingData.postcode' => in_array($this->chosenShipping, ['courier', 'nova-poshta']) ? 'required|string|max:255' : 'nullable|string|max:255',
            'comment' => 'nullable|string|max:500',
        ]);

        Log::info('Выбрана опция доставки', [
            'cart_id' => $this->cart->id,
            'chosen_shipping' => $this->chosenShipping,
        ]);

        if (!$this->chosenShipping) {
            Log::error('Опция доставки не выбрана', [
                'cart_id' => $this->cart->id,
            ]);
            $this->addError('chosenShipping', __('messages.checkout.shipping_option_not_found'));
            return;
        }

        $option = ShippingManifest::getOptions($this->cart)->first(
            fn($opt) => $opt->getIdentifier() === $this->chosenShipping
        );

        if (!$option) {
            Log::error('Опция доставки не найдена', [
                'cart_id' => $this->cart->id,
                'chosen_shipping' => $this->chosenShipping,
            ]);
            $this->addError('chosenShipping', __('messages.checkout.shipping_option_not_found'));
            return;
        }

        try {
            // Устанавливаем опцию доставки
            $this->cart->setShippingOption($option);

            // Сохраняем дополнительные данные в meta
            $this->cart->meta = array_merge($this->cart->meta ? $this->cart->meta->toArray() : [], [
                'shipping_option' => $this->chosenShipping,
                'payment_option' => 'cash_on_delivery',
                'shipping_total' => $option->price->value ?? 0,
                'shipping_sub_total' => $option->price->value ?? 0,
                'shipping_tax_breakdown' => [],
                'sub_total' => $this->cart->subTotal->value ?? 0,
                'total' => $this->cart->total->value ?? 0,
                'tax_total' => 0, // Налоги отключены
            ]);
            $this->cart->save();
            $this->cart->refresh();

            Log::info('Опция доставки установлена', [
                'cart_id' => $this->cart->id,
                'shipping_option' => $this->cart->meta['shipping_option'] ?? null,
                'payment_option' => $this->cart->meta['payment_option'] ?? null,
                'shipping_option_object' => [
                    'name' => $option->name,
                    'description' => $option->description,
                    'identifier' => $option->identifier,
                    'price' => $option->price->value ?? 0,
                ],
                'meta_shipping_total' => $this->cart->meta['shipping_total'] ?? null,
                'meta_shipping_sub_total' => $this->cart->meta['shipping_sub_total'] ?? null,
                'meta_shipping_tax_breakdown' => $this->cart->meta['shipping_tax_breakdown'] ?? null,
                'meta_sub_total' => $this->cart->meta['sub_total'] ?? null,
                'meta_total' => $this->cart->meta['total'] ?? null,
                'meta_tax_total' => $this->cart->meta['tax_total'] ?? null,
            ]);

            if ($this->chosenShipping === 'pickup') {
                $this->shippingData['city'] = $this->shippingData['city'] ?? 'Не требуется';
                $this->shippingData['line_one'] = $this->shippingData['line_one'] ?? 'Самовывоз';
                $this->shippingData['postcode'] = $this->shippingData['postcode'] ?? '00000';
            }

            $this->cart->shippingAddress->fill([
                'city' => $this->shippingData['city'],
                'line_one' => $this->shippingData['line_one'],
                'postcode' => $this->shippingData['postcode'],
                'meta' => array_merge($this->cart->shippingAddress->meta ? $this->cart->shippingAddress->meta->toArray() : [], [
                    'shipping_option' => $this->chosenShipping,
                ]),
            ])->save();

            $this->cart->setShippingAddress($this->cart->shippingAddress);
            $this->cart->refresh();

            $savedAddress = CartAddress::where('cart_id', $this->cart->id)
                ->where('type', 'shipping')
                ->first();
            Log::info('Адрес доставки сохранен', [
                'cart_id' => $this->cart->id,
                'shipping_option' => $savedAddress->meta['shipping_option'] ?? null,
                'shipping_data' => $savedAddress->toArray(),
            ]);

            $this->cart->calculate();
            $this->loadShippingOptions();
        } catch (\Exception $e) {
            Log::error('Ошибка при сохранении адреса доставки', [
                'cart_id' => $this->cart->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->addError('shipping', 'Не удалось сохранить адрес доставки.');
            return;
        }

        try {
            Log::info('Состояние корзины перед созданием заказа', [
                'cart_id' => $this->cart->id,
                'meta' => $this->cart->meta ? $this->cart->meta->toArray() : null,
                'shipping_option' => $this->cart->meta['shipping_option'] ?? null,
                'payment_option' => $this->cart->meta['payment_option'] ?? null,
                'shipping_address' => $this->cart->shippingAddress ? $this->cart->shippingAddress->toArray() : null,
                'meta_shipping_total' => $this->cart->meta['shipping_total'] ?? null,
                'meta_shipping_sub_total' => $this->cart->meta['shipping_sub_total'] ?? null,
                'meta_shipping_tax_breakdown' => $this->cart->meta['shipping_tax_breakdown'] ?? null,
                'meta_sub_total' => $this->cart->meta['sub_total'] ?? null,
                'meta_total' => $this->cart->meta['total'] ?? null,
                'meta_tax_total' => $this->cart->meta['tax_total'] ?? null,
                'cart_lines' => $this->cart->lines->map(fn($line) => [
                    'id' => $line->id,
                    'subTotal' => $line->subTotal instanceof \Lunar\DataTypes\Price
                        ? ['value' => $line->subTotal->value, 'formatted' => $line->subTotal->formatted()]
                        : $line->subTotal,
                ])->toArray(),
            ]);

            $order = $this->cart->createOrder();
            if ($this->comment) {
                $order->meta = array_merge($order->meta ? $order->meta->toArray() : [], ['comment' => $this->comment]);
                $order->save();
            }

            CartSession::forget();
            $this->redirect('/');
        } catch (\Exception $e) {
            Log::error('Ошибка при создании заказа', [
                'cart_id' => $this->cart->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'shipping_option' => $this->cart->meta['shipping_option'] ?? null,
                'payment_option' => $this->cart->meta['payment_option'] ?? null,
                'cart_shipping_address' => $this->cart->shippingAddress ? $this->cart->shippingAddress->toArray() : null,
            ]);
            $this->addError('order', 'Не удалось создать заказ. Пожалуйста, попробуйте снова.');
        }
    }

    /**
     * Обновление поискового запроса для города
     */
    public function updatedCitySearchTerm(): void
    {
        $this->showCityDropdown = true;
        $this->shippingData['line_one'] = '';
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
            $this->addError('shippingData.city', __('messages.checkout.city_load_error'));
        }
    }

    /**
     * Выбор города
     */
    public function selectCity($cityName): void
    {
        $this->shippingData['city'] = $cityName;
        $this->citySearchTerm = $cityName;
        $this->showCityDropdown = false;
        $this->shippingData['line_one'] = '';
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
            $this->addError('shippingData.city', __('messages.checkout.warehouse_load_error'));
        }

        $this->cart->calculate();
        $this->loadShippingOptions();
    }

    /**
     * Обновление города доставки
     */
    public function updatedShippingDataCity($cityName): void
    {
        $this->shippingData['line_one'] = '';
        $this->npWarehouses = [];

        $city = collect($this->npCities)->first(fn($c) => ($c['MainDescription'] ?? '') === $cityName);

        if ($city && isset($city['DeliveryCity'])) {
            Log::info('Обновлен город через updatedShippingDataCity', [
                'city' => $cityName,
                'delivery_city' => $city['DeliveryCity'],
                'ref' => $city['Ref'],
            ]);
            $this->fetchNovaPoshtaWarehouses($city['DeliveryCity']);
        } else {
            Log::error('DeliveryCity не найден для города в updatedShippingDataCity', [
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
                $this->addError('shippingData.line_one', __('messages.checkout.warehouse_empty_error'));
            }
        } else {
            Log::error('Ошибка при получении отделений Новой Почты', [
                'cityRef' => $cityRef,
                'response' => $response->json(),
                'errors' => $response->json('errors') ?? 'Нет деталей ошибки',
            ]);
            $this->npWarehouses = [];
            $this->addError('shippingData.line_one', __('messages.checkout.warehouse_load_error'));
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
        Log::info('Рендеринг CheckoutPage', [
            'current_step' => $this->currentStep,
            'shipping_exists' => $this->cart->shippingAddress instanceof \Lunar\Models\CartAddress,
            'cart_id' => $this->cart ? $this->cart->id : null,
            'chosen_shipping' => $this->chosenShipping,
            'cart_meta' => $this->cart->meta ? $this->cart->meta->toArray() : null,
        ]);

        return view('livewire.checkout-page', [
            'shippingOption' => $this->getShippingOptionProperty(),
            'steps' => $this->steps,
            'shippingOptions' => $this->shippingOptions,
            'npCities' => $this->npCities,
            'npWarehouses' => $this->npWarehouses,
        ])->layout('layouts.checkout');
    }
}
