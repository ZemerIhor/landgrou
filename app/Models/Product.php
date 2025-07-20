<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lunar\Models\Product as LunarProduct;
use Lunar\FieldTypes\TranslatedText;
use Illuminate\Support\Str;

class Product extends LunarProduct
{
    use HasFactory;

    /**
     * Определяет отношение к основному URL продукта.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function defaultUrl(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        $locale = app()->getLocale();
        $languageId = \Lunar\Models\Language::where('code', $locale)->first()->id ?? 1;

        return $this->morphOne(\Lunar\Models\Url::class, 'element')
            ->where('default', true)
            ->where('language_id', $languageId);
    }

    /**
     * Получает slug продукта.
     *
     * @return string
     */
    public function getSlugAttribute(): string
    {
        // Проверяем defaultUrl для текущей локали
        if ($this->defaultUrl && $this->defaultUrl->slug) {
            return $this->defaultUrl->slug;
        }

        // Проверяем любой default URL как запасной вариант
        $fallbackUrl = $this->urls()->where('default', true)->first();
        if ($fallbackUrl && $fallbackUrl->slug) {
            return $fallbackUrl->slug;
        }

        // Используем имя из attribute_data
        $locale = app()->getLocale();
        $name = $this->attribute_data['name'] ?? null;

        if ($name instanceof TranslatedText && isset($name->value[$locale])) {
            $slug = Str::slug($name->value[$locale]);
            if ($slug) {
                return $slug;
            }
        }

        // Резервное значение
        return 'product-' . $this->id;
    }
}
