<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Product;

class AttributeSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $attributes = $this->getSeedData('attributes');

        $attributeGroup = AttributeGroup::where('handle', 'details')->first();

        if (! $attributeGroup) {
            $attributeGroup = AttributeGroup::create([
                'attributable_type' => Product::morphName(),
                'name' => [
                    'en' => 'Details',
                    'uk' => 'Деталі',
                ],
                'handle' => 'details',
                'position' => 1,
            ]);
        }

        DB::transaction(function () use ($attributes, $attributeGroup) {
            foreach ($attributes as $attribute) {
                $attributeType = $attribute->attribute_type;

                if ($attributeType === Product::class) {
                    $attributeType = 'product';
                }

                $translations = $attribute->name;
                if (is_object($translations)) {
                    $translations = (array) $translations;
                }
                if (! is_array($translations)) {
                    $translations = [
                        'en' => $translations,
                        'uk' => $translations,
                    ];
                }

                Attribute::firstOrCreate([
                    'handle' => $attribute->handle,
                    'attribute_type' => $attributeType,
                ], [
                    'attribute_group_id' => $attributeGroup->id,
                    'section' => 'main',
                    'type' => $attribute->type,
                    'required' => false,
                    'searchable' => true,
                    'filterable' => false,
                    'system' => false,
                    'position' => $attributeGroup->attributes()->count() + 1,
                    'name' => $translations,
                    'description' => $translations,
                    'configuration' => (array) $attribute->configuration,
                ]);
            }
        });
    }
}
