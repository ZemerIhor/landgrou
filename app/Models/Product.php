<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lunar\Models\Product as LunarProduct;
use Lunar\FieldTypes\TranslatedText;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends LunarProduct
{
    use HasFactory;

    public function localizedUrl(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        $locale = app()->getLocale();
        $languageId = \Lunar\Models\Language::where('code', $locale)->first()->id ?? 1;

        return $this->morphOne(\Lunar\Models\Url::class, 'element')
            ->where('language_id', $languageId);
    }

    public function defaultUrl(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(\Lunar\Models\Url::class, 'element')
            ->where('default', true);
    }

    public function getSlugAttribute(): string
    {
        if ($this->localizedUrl && $this->localizedUrl->slug) {
            return $this->localizedUrl->slug;
        }

        if ($this->defaultUrl && $this->defaultUrl->slug) {
            return $this->defaultUrl->slug;
        }

        $locale = app()->getLocale();
        $name = $this->attribute_data['name'] ?? null;

        if ($name instanceof TranslatedText && isset($name->value[$locale])) {
            $slug = Str::slug($name->value[$locale]);
            if ($slug) {
                return $slug;
            }
        }

        return 'product-' . $this->id;
    }

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        // Убираем cast для technical_specifications, так как это вызывает конфликт
    ];

    /**
     * Get the article number for display
     */
    public function getDisplayArticleNumberAttribute(): string
    {
        return $this->article_number ?? ('000' . str_pad($this->id, 6, '0', STR_PAD_LEFT));
    }

    /**
     * Get compliance standard with fallback
     */
    public function getDisplayComplianceStandardAttribute(): string
    {
        return $this->compliance_standard ?? 'ДСТУ 2042-92 «Брикети торфові для комунально- побутових»';
    }

    /**
     * Get packaging type with fallback
     */
    public function getDisplayPackagingTypeAttribute(): string
    {
        return $this->packaging_type ?? 'В поліетиленових мішках по 25кг';
    }

    /**
     * Get technical specifications for table display
     */
    public function getTechnicalSpecificationsForTableAttribute(): array
    {
        if ($this->technical_specifications) {
            $specs = is_string($this->technical_specifications) 
                ? json_decode($this->technical_specifications, true) 
                : $this->technical_specifications;
            
            if (is_array($specs)) {
                return $specs;
            }
        }

        // Default specifications based on attributes
        return [
            [
                'name' => 'Масова доля загальної вологи (Wp)',
                'standard' => '20%',
                'actual' => $this->getAttributeValue('moisture_content') ? $this->getAttributeValue('moisture_content') . '%' : '19.1%'
            ],
            [
                'name' => 'Зольність (Ad)',
                'standard' => '23%',
                'actual' => $this->getAttributeValue('ash_content') ? $this->getAttributeValue('ash_content') . '%' : '18.3%'
            ],
            [
                'name' => 'Механічна міцність, %',
                'standard' => '96.6%',
                'actual' => $this->getAttributeValue('mechanical_strength') ? $this->getAttributeValue('mechanical_strength') . '%' : '96.6%'
            ],
            [
                'name' => 'Теплота згоряння Ккал/кг',
                'standard' => '>3500',
                'actual' => $this->getAttributeValue('heat_combustion_kcal') ?? '4155'
            ],
            [
                'name' => 'Теплота згоряння МДж/кг',
                'standard' => '>14.65',
                'actual' => $this->getAttributeValue('heat_combustion_mj') ?? '17.387'
            ],
            [
                'name' => 'Вміст сірки, %',
                'standard' => '-',
                'actual' => $this->getAttributeValue('sulfur_content') ? $this->getAttributeValue('sulfur_content') . '%' : '0.24%'
            ],
            [
                'name' => 'Забруднення радіонуклідами',
                'standard' => 'не нормується',
                'actual' => $this->getAttributeValue('radioactive_contamination') ?? 'не виявлено'
            ]
        ];
    }

    /**
     * Get main specifications for product card
     */
    public function getMainSpecificationsAttribute(): array
    {
        return [
            'calorific_value' => [
                'label' => 'Калорійність',
                'value' => $this->getAttributeValue('calorific_value'),
                'unit' => 'ккал/кг',
                'prefix' => 'до '
            ],
            'moisture_content' => [
                'label' => 'Масова доля загальної вологи',
                'value' => $this->getAttributeValue('moisture_content'),
                'unit' => '%',
                'prefix' => 'до '
            ],
            'mechanical_strength' => [
                'label' => 'Механічна міцність',
                'value' => $this->getAttributeValue('mechanical_strength'),
                'unit' => '%',
                'prefix' => ''
            ],
            'ash_content' => [
                'label' => 'Зольність',
                'value' => $this->getAttributeValue('ash_content'),
                'unit' => '%',
                'prefix' => ''
            ],
            'dimensions' => [
                'label' => 'Розміри',
                'value' => $this->getAttributeValue('dimensions'),
                'unit' => 'мм',
                'prefix' => ''
            ],
            'raw_material' => [
                'label' => 'Сировина',
                'value' => $this->getAttributeValue('raw_material'),
                'unit' => '',
                'prefix' => ''
            ],
        ];
    }
}
