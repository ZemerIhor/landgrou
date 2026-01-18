<?php

use Illuminate\Database\Migrations\Migration;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Product;
use Lunar\Models\ProductType;

return new class extends Migration
{
    public function up(): void
    {
        $attributeGroup = AttributeGroup::where('handle', 'details')->first();

        if (! $attributeGroup) {
            $attributeGroup = AttributeGroup::create([
                'attributable_type' => Product::morphName(),
                'name' => [
                    'en' => 'Details',
                ],
                'handle' => 'details',
                'position' => 1,
            ]);
        }

        $attribute = Attribute::firstOrCreate(
            [
                'handle' => 'short_description',
                'attribute_type' => 'product',
            ],
            [
                'attribute_group_id' => $attributeGroup->id,
                'section' => 'main',
                'type' => TranslatedText::class,
                'required' => false,
                'searchable' => true,
                'filterable' => false,
                'system' => false,
                'position' => $attributeGroup->attributes()->count() + 1,
                'name' => [
                    'en' => 'Short Description',
                ],
                'description' => [
                    'en' => 'Short Description',
                ],
                'configuration' => [],
            ]
        );

        ProductType::query()->each(function (ProductType $productType) use ($attribute) {
            $productType->mappedAttributes()->syncWithoutDetaching([$attribute->id]);
        });
    }

    public function down(): void
    {
        $attribute = Attribute::where('handle', 'short_description')
            ->where('attribute_type', 'product')
            ->first();

        if ($attribute) {
            ProductType::query()->each(function (ProductType $productType) use ($attribute) {
                $productType->mappedAttributes()->detach($attribute->id);
            });

            $attribute->delete();
        }
    }
};
