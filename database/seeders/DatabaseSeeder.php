<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BaseLunarSeeder::class,
            AttributeSeeder::class,
            ProductAttributesSeeder::class,
            CollectionSeeder::class,
            TaxSeeder::class,
            ShippingSeeder::class,
            ProductFiltersSeederNew::class,
            ProductSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
