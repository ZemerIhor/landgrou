<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Lunar\Models\Attribute;
use Lunar\Models\Currency;
use Lunar\Models\TaxClass;
use Lunar\Models\Price;

class DemoProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем валюту и налоговый класс
        $currency = Currency::first();
        $taxClass = TaxClass::first();

        if (!$currency || !$taxClass) {
            $this->command->error('Please run currency and tax class seeders first!');
            return;
        }

        // Создаем демо-продукт как на скриншоте
        $product = Product::create([
            'status' => 'published',
            'attribute_data' => [
                'name' => [
                    'uk' => 'Паливний торфобрикет в поліетиленових мішках по 25 кг',
                    'en' => 'Fuel Peat Briquette in Polyethylene Bags 25 kg',
                    'ru' => 'Топливный торфобрикет в полиэтиленовых мешках по 25 кг'
                ],
                'description' => [
                    'uk' => 'Брикет торф\'яний відповідає вимогам ДСТУ 2042-92 «Брикети торфові для комунально-побутових потреб». Має високу теплотворну здатність, зручний у використанні, екологічний, ідеально підходить для опалення будинків та приміщень різного типу.',
                    'en' => 'Peat briquette meets the requirements of DSTU 2042-92 "Peat briquettes for municipal and household needs". Has high calorific value, convenient to use, ecological, ideal for heating houses and premises of various types.',
                    'ru' => 'Брикет торфяной соответствует требованиям ДСТУ 2042-92 «Брикеты торфяные для коммунально-бытовых нужд». Имеет высокую теплотворную способность, удобен в использовании, экологичен, идеально подходит для отопления домов и помещений различного типа.'
                ],
                // Основные характеристики
                'calorific_value' => '4500',
                'moisture_content' => '19.1',
                'mechanical_strength' => '95.6',
                'ash_content' => '12-18',
                'dimensions' => '40-75/65/180',
                'raw_material' => '100% натуральний торф',
                // Технические характеристики
                'heat_combustion_kcal' => '4155',
                'heat_combustion_mj' => '17.387',
                'sulfur_content' => '0.24',
                'radioactive_contamination' => 'не виявлено',
            ],
            'article_number' => '00031489',
            'compliance_standard' => 'ДСТУ 2042-92 «Брикети торфові для комунально- побутових»',
            'packaging_type' => 'В поліетиленових мішках по 25кг',
            'technical_specifications' => [
                [
                    'name' => 'Масова доля загальної вологи (Wp)',
                    'standard' => '20%',
                    'actual' => '19.1%'
                ],
                [
                    'name' => 'Зольність (Ad)',
                    'standard' => '23%',
                    'actual' => '18.3%'
                ],
                [
                    'name' => 'Механічна міцність, %',
                    'standard' => '96.6%',
                    'actual' => '95.6%'
                ],
                [
                    'name' => 'Теплота згоряння Ккал/кг',
                    'standard' => '>3500',
                    'actual' => '4155'
                ],
                [
                    'name' => 'Теплота згоряння МДж/кг',
                    'standard' => '>14.65',
                    'actual' => '17.387'
                ],
                [
                    'name' => 'Вміст сірки, %',
                    'standard' => '-',
                    'actual' => '0.24%'
                ],
                [
                    'name' => 'Забруднення радіонуклідами',
                    'standard' => 'не нормується',
                    'actual' => 'не виявлено'
                ]
            ]
        ]);

        // Создаем вариант продукта
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'PEAT-BRICK-25KG-001',
            'gtin' => '1234567890123',
            'shippable' => true,
            'purchasable' => 'always',
            'stock' => 100,
            'backorder' => 0,
            'requires_shipping' => true,
            'tax_class_id' => $taxClass->id,
        ]);

        // Создаем цену
        Price::create([
            'currency_id' => $currency->id,
            'priceable_type' => ProductVariant::class,
            'priceable_id' => $variant->id,
            'price' => 25000, // 250.00 грн
            'min_quantity' => 1,
        ]);

        // Создаем URL для продукта
        \Lunar\Models\Url::create([
            'slug' => 'palivnyi-torfobryket-25kg',
            'default' => true,
            'language_id' => \Lunar\Models\Language::where('code', 'uk')->first()?->id ?? 1,
            'element_type' => Product::class,
            'element_id' => $product->id,
        ]);

        // Создаем дополнительные URL для других языков
        if ($enLang = \Lunar\Models\Language::where('code', 'en')->first()) {
            \Lunar\Models\Url::create([
                'slug' => 'fuel-peat-briquette-25kg',
                'default' => false,
                'language_id' => $enLang->id,
                'element_type' => Product::class,
                'element_id' => $product->id,
            ]);
        }

        if ($ruLang = \Lunar\Models\Language::where('code', 'ru')->first()) {
            \Lunar\Models\Url::create([
                'slug' => 'toplivnyi-torfobriket-25kg',
                'default' => false,
                'language_id' => $ruLang->id,
                'element_type' => Product::class,
                'element_id' => $product->id,
            ]);
        }

        $this->command->info('Demo product "Паливний торфобрикет" created successfully!');
        $this->command->info('Product ID: ' . $product->id);
        $this->command->info('Product URL: /uk/products/palivnyi-torfobryket-25kg');
    }
}
