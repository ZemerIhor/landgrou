<?php

namespace Database\Seeders;

use App\Models\PeatType;
use App\Models\ProductWeight;
use Illuminate\Database\Seeder;

class ProductFiltersSeederNew extends Seeder
{
    public function run(): void
    {
        // Создаем виды торфа
        $types = [
            [
                'name' => ['en' => 'Agricultural Peat', 'pl' => 'Torf rolniczy'],
                'slug' => 'agricultural-peat',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'Substrate Peat', 'uk' => 'Субстратний торф'],
                'slug' => 'substrate-peat',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => ['en' => 'High-Moor Peat', 'uk' => 'Верховий торф'],
                'slug' => 'high-moor-peat',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            PeatType::updateOrCreate(['slug' => $type['slug']], $type);
        }

        // Создаем веса продуктов
        $weights = [
            ['name' => ['en' => '10 kg', 'uk' => '10 кг'], 'value' => '10', 'sort_order' => 1, 'is_active' => true],
            ['name' => ['en' => '20 kg', 'uk' => '20 кг'], 'value' => '20', 'sort_order' => 2, 'is_active' => true],
            ['name' => ['en' => '25 kg', 'uk' => '25 кг'], 'value' => '25', 'sort_order' => 3, 'is_active' => true],
            ['name' => ['en' => 'Bulk', 'uk' => 'Наливом'], 'value' => 'bulk', 'sort_order' => 4, 'is_active' => true],
        ];

        foreach ($weights as $weight) {
            ProductWeight::updateOrCreate(['value' => $weight['value']], $weight);
        }

        $this->command->info('✅ Peat types and product weights seeded successfully!');
    }
}
