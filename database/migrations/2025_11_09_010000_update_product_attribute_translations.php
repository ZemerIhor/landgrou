<?php

use Illuminate\Database\Migrations\Migration;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Product;

return new class extends Migration
{
    private function toArrayValue($value): array
    {
        if ($value instanceof \Illuminate\Support\Collection) {
            return $value->toArray();
        }

        if (is_object($value)) {
            return (array) $value;
        }

        return is_array($value) ? $value : [];
    }

    public function up(): void
    {
        $attributeGroup = AttributeGroup::where('handle', 'details')
            ->where('attributable_type', Product::morphName())
            ->first();

        if ($attributeGroup) {
            $attributeGroup->update([
                'name' => array_merge($this->toArrayValue($attributeGroup->name), [
                    'en' => 'Details',
                    'uk' => 'Деталі',
                ]),
            ]);
        }

        $translations = [
            'name' => ['en' => 'Name', 'uk' => 'Назва'],
            'description' => ['en' => 'Description', 'uk' => 'Опис'],
            'short_description' => ['en' => 'Short Description', 'uk' => 'Короткий опис'],
        ];

        foreach ($translations as $handle => $labels) {
            $attribute = Attribute::where('handle', $handle)
                ->where('attribute_type', 'product')
                ->first();

            if (! $attribute) {
                continue;
            }

            $attribute->update([
                'name' => array_merge($this->toArrayValue($attribute->name), $labels),
                'description' => array_merge($this->toArrayValue($attribute->description), $labels),
            ]);
        }
    }

    public function down(): void
    {
        $attributeGroup = AttributeGroup::where('handle', 'details')
            ->where('attributable_type', Product::morphName())
            ->first();

        if ($attributeGroup) {
            $attributeGroup->update([
                'name' => array_merge($this->toArrayValue($attributeGroup->name), [
                    'en' => 'Details',
                ]),
            ]);
        }

        $translations = [
            'name' => ['en' => 'Name'],
            'description' => ['en' => 'Description'],
            'short_description' => ['en' => 'Short Description'],
        ];

        foreach ($translations as $handle => $labels) {
            $attribute = Attribute::where('handle', $handle)
                ->where('attribute_type', 'product')
                ->first();

            if (! $attribute) {
                continue;
            }

            $attribute->update([
                'name' => array_merge($this->toArrayValue($attribute->name), $labels),
                'description' => array_merge($this->toArrayValue($attribute->description), $labels),
            ]);
        }
    }
};
