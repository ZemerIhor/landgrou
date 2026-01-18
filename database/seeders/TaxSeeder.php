<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\Models\Country;
use Lunar\Models\TaxClass;
use Lunar\Models\TaxRate;
use Lunar\Models\TaxZone;
use Lunar\Models\TaxZoneCountry;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $taxClass = TaxClass::getDefault();

        if (! $taxClass) {
            $taxClass = TaxClass::create([
                'name' => 'Default Tax Class',
                'default' => true,
            ]);
        }

        $ukCountry = Country::firstWhere('iso3', 'GBR');

        if (! $ukCountry) {
            $ukCountry = Country::create([
                'name' => 'United Kingdom',
                'iso3' => 'GBR',
                'iso2' => 'GB',
                'phonecode' => '+44',
                'capital' => 'London',
                'currency' => 'GBP',
                'native' => 'en',
                'emoji' => 'GB',
                'emoji_u' => 'GB',
            ]);
        }

        $ukTaxZone = TaxZone::factory()->create([
            'name' => 'UK',
            'active' => true,
            'default' => true,
            'zone_type' => 'country',
        ]);

        TaxZoneCountry::factory()->create([
            'country_id' => $ukCountry->id,
            'tax_zone_id' => $ukTaxZone->id,
        ]);

        $ukRate = TaxRate::factory()->create([
            'name' => 'VAT',
            'tax_zone_id' => $ukTaxZone->id,
            'priority' => 1,
        ]);

        $ukRate->taxRateAmounts()->createMany([
            [
                'percentage' => 20,
                'tax_class_id' => $taxClass->id,
            ],
        ]);
    }
}
