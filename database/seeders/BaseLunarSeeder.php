<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Channel;
use Lunar\Models\CollectionGroup;
use Lunar\Models\Country;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;
use Lunar\Models\Language;
use Lunar\Models\Product;
use Lunar\Models\ProductType;
use Lunar\Models\TaxClass;

class BaseLunarSeeder extends Seeder
{
    public function run(): void
    {
        if (! Channel::whereDefault(true)->exists()) {
            Channel::create([
                'name' => 'Webstore',
                'handle' => 'webstore',
                'default' => true,
                'url' => 'http://localhost',
            ]);
        }

        if (! Language::whereDefault(true)->exists()) {
            Language::create([
                'code' => 'en',
                'name' => 'English',
                'default' => true,
            ]);
        }

        if (! Currency::whereDefault(true)->exists()) {
            Currency::create([
                'code' => 'USD',
                'name' => 'US Dollar',
                'exchange_rate' => 1,
                'decimal_places' => 2,
                'default' => true,
                'enabled' => true,
            ]);
        }

        if (! CustomerGroup::whereDefault(true)->exists()) {
            CustomerGroup::create([
                'name' => 'Retail',
                'handle' => 'retail',
                'default' => true,
            ]);
        }

        if (! TaxClass::whereDefault(true)->exists()) {
            TaxClass::create([
                'name' => 'Default Tax Class',
                'default' => true,
            ]);
        }

        if (! ProductType::count()) {
            ProductType::create([
                'name' => 'Default',
            ]);
        }

        if (! CollectionGroup::count()) {
            CollectionGroup::create([
                'name' => 'Main',
                'handle' => 'main',
            ]);
        }

        if (! AttributeGroup::where('handle', 'details')->exists()) {
            AttributeGroup::create([
                'attributable_type' => Product::morphName(),
                'name' => [
                    'en' => 'Details',
                ],
                'handle' => 'details',
                'position' => 1,
            ]);
        }

        $countries = [
            [
                'name' => 'United Kingdom',
                'iso3' => 'GBR',
                'iso2' => 'GB',
                'phonecode' => '+44',
                'capital' => 'London',
                'currency' => 'GBP',
                'native' => 'en',
                'emoji' => 'GB',
                'emoji_u' => 'GB',
            ],
            [
                'name' => 'United States',
                'iso3' => 'USA',
                'iso2' => 'US',
                'phonecode' => '+1',
                'capital' => 'Washington',
                'currency' => 'USD',
                'native' => 'en',
                'emoji' => 'US',
                'emoji_u' => 'US',
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso3' => $country['iso3']],
                $country
            );
        }
    }
}
