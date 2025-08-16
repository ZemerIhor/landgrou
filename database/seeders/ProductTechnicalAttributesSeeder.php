<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Product;
use Lunar\FieldTypes\Number;
use Lunar\FieldTypes\Text;

class ProductTechnicalAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем группу атрибутов для технических характеристик
        $technicalGroup = AttributeGroup::firstOrCreate([
            'handle' => 'technical_specifications',
        ], [
            'attributable_type' => Product::class,
            'name' => [
                'uk' => 'Технічні характеристики',
                'en' => 'Technical Specifications',
                'ru' => 'Технические характеристики'
            ],
            'position' => 1,
        ]);

        // Создаем группу для основных характеристик
        $mainGroup = AttributeGroup::firstOrCreate([
            'handle' => 'main_specifications',
        ], [
            'attributable_type' => Product::class,
            'name' => [
                'uk' => 'Основні характеристики',
                'en' => 'Main Specifications',
                'ru' => 'Основные характеристики'
            ],
            'position' => 2,
        ]);

        // Атрибуты для карточки товара
        $attributes = [
            // Основные характеристики
            [
                'handle' => 'calorific_value',
                'group' => $mainGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Калорійність',
                    'en' => 'Calorific Value',
                    'ru' => 'Калорийность'
                ],
                'configuration' => [
                    'min' => 0,
                    'max' => 10000,
                ]
            ],
            [
                'handle' => 'moisture_content',
                'group' => $mainGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Масова доля загальної вологи',
                    'en' => 'Total Moisture Content',
                    'ru' => 'Массовая доля общей влаги'
                ],
                'configuration' => [
                    'min' => 0,
                    'max' => 100,
                ]
            ],
            [
                'handle' => 'mechanical_strength',
                'group' => $mainGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Механічна міцність',
                    'en' => 'Mechanical Strength',
                    'ru' => 'Механическая прочность'
                ],
                'configuration' => [
                    'min' => 0,
                    'max' => 100,
                ]
            ],
            [
                'handle' => 'ash_content',
                'group' => $mainGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Зольність',
                    'en' => 'Ash Content',
                    'ru' => 'Зольность'
                ],
                'configuration' => [
                    'min' => 0,
                    'max' => 100,
                ]
            ],
            [
                'handle' => 'dimensions',
                'group' => $mainGroup->id,
                'type' => Text::class,
                'name' => [
                    'uk' => 'Розміри',
                    'en' => 'Dimensions',
                    'ru' => 'Размеры'
                ]
            ],
            [
                'handle' => 'raw_material',
                'group' => $mainGroup->id,
                'type' => Text::class,
                'name' => [
                    'uk' => 'Сировина',
                    'en' => 'Raw Material',
                    'ru' => 'Сырье'
                ]
            ],
            // Технические характеристики для таблицы
            [
                'handle' => 'heat_combustion_kcal',
                'group' => $technicalGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Теплота згоряння Ккал/кг',
                    'en' => 'Heat of Combustion Kcal/kg',
                    'ru' => 'Теплота сгорания Ккал/кг'
                ]
            ],
            [
                'handle' => 'heat_combustion_mj',
                'group' => $technicalGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Теплота згоряння МДж/кг',
                    'en' => 'Heat of Combustion MJ/kg',
                    'ru' => 'Теплота сгорания МДж/кг'
                ]
            ],
            [
                'handle' => 'sulfur_content',
                'group' => $technicalGroup->id,
                'type' => Number::class,
                'name' => [
                    'uk' => 'Вміст сірки, %',
                    'en' => 'Sulfur Content, %',
                    'ru' => 'Содержание серы, %'
                ],
                'configuration' => [
                    'min' => 0,
                    'max' => 100,
                ]
            ],
            [
                'handle' => 'radioactive_contamination',
                'group' => $technicalGroup->id,
                'type' => Text::class,
                'name' => [
                    'uk' => 'Забруднення радіонуклідами',
                    'en' => 'Radioactive Contamination',
                    'ru' => 'Загрязнение радионуклидами'
                ]
            ]
        ];

        foreach ($attributes as $attributeData) {
            Attribute::firstOrCreate([
                'handle' => $attributeData['handle'],
            ], [
                'attribute_type' => Product::class,
                'attribute_group_id' => $attributeData['group'],
                'type' => $attributeData['type'],
                'name' => $attributeData['name'],
                'configuration' => $attributeData['configuration'] ?? [],
                'required' => false,
                'system' => false,
            ]);
        }

        $this->command->info('Product technical attributes created successfully!');
    }
}
