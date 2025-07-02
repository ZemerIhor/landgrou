<?php

namespace App\Modifiers;

use Closure;
use Illuminate\Support\Facades\Log;
use Lunar\Base\ShippingModifier as BaseShippingModifier;
use Lunar\DataTypes\Price;
use Lunar\DataTypes\ShippingOption;
use Lunar\Facades\ShippingManifest;
use Lunar\Models\Contracts\Cart; // Use the interface
use Lunar\Models\TaxClass;

class ShippingModifier extends BaseShippingModifier
{
    public function handle(Cart $cart, Closure $next)
    {
        Log::debug('Обработка ShippingModifier', ['cart_id' => $cart->id]);

        // Check if currency is set
        if (!$cart->currency) {
            Log::error('Валюта корзины не определена', ['cart_id' => $cart->id]);
            return $next($cart);
        }

        // Check if shipping tables are enabled
        if (config('shipping-tables.enabled', false)) {
            Log::debug('Таблицы доставки включены, пропускаем кастомные опции');
            return $next($cart);
        }

        // Get or create default tax class
        $taxClass = TaxClass::getDefault() ?? TaxClass::firstOrCreate(
            ['name' => 'Default'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Add shipping options
        ShippingManifest::addOptions(collect([
            new ShippingOption(
                name: 'Самовивіз з магазину',
                description: 'Ви можете забрати товар самостійно з магазину.',
                identifier: 'pickup',
                price: new Price(0, $cart->currency, 1),
                taxClass: $taxClass,
                collect: true
            ),
            new ShippingOption(
                name: 'Нова Пошта',
                description: 'Доставка на відділення Нової Пошти.',
                identifier: 'nova-poshta',
                price: new Price(0, $cart->currency, 1),
                taxClass: $taxClass
            ),
            new ShippingOption(
                name: 'Кур’єрська доставка',
                description: 'Доставка кур’єром за адресою.',
                identifier: 'courier',
                price: new Price(0, $cart->currency, 1),
                taxClass: $taxClass
            ),
        ]));

        Log::debug('Опции доставки добавлены', [
            'options' => ['pickup', 'nova-poshta', 'courier'],
        ]);

        return $next($cart);
    }
}
