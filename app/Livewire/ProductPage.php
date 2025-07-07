<?php

namespace App\Livewire;

use App\Traits\FetchesUrls;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\Cart;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductPage extends Component
{
    use FetchesUrls;

    public array $selectedOptionValues = [];
    public int $quantity = 1;

    public array $displayAttributes = [
        'calories',
        'moisture',
        'strength',
        'ash',
        'dimensions',
        'material',
        'packaging',
    ];

    public array $productAttributes = [
        'calories' => ['en' => 'Calories', 'uk' => 'Калорійність'],
        'moisture' => ['en' => 'Moisture content', 'uk' => 'Масова доля загальної вологи'],
        'strength' => ['en' => 'Mechanical strength', 'uk' => 'Механічна міцність'],
        'ash' => ['en' => 'Ash content', 'uk' => 'Зольність'],
        'dimensions' => ['en' => 'Dimensions', 'uk' => 'Розміри'],
        'material' => ['en' => 'Material', 'uk' => 'Сировина'],
        'packaging' => ['en' => 'Packaging type', 'uk' => 'Вид пакування'],
    ];

    public array $detailedAttributes = [
        'moisture' => [
            'name' => ['en' => 'Moisture content', 'uk' => 'Масова доля загальної вологи'],
            'norm' => '20%',
            'value' => '19.1%',
        ],
        'ash' => [
            'name' => ['en' => 'Ash content', 'uk' => 'Зольність'],
            'norm' => '23%',
            'value' => '18.3%',
        ],
        'strength' => [
            'name' => ['en' => 'Mechanical strength', 'uk' => 'Механічна міцність'],
            'norm' => '96.6%',
            'value' => '96.6%',
        ],
        'calories_kcal' => [
            'name' => ['en' => 'Calorific value kcal/kg', 'uk' => 'Теплота згорання Ккал/кг'],
            'norm' => '>3500',
            'value' => '4155',
        ],
        'calories_mj' => [
            'name' => ['en' => 'Calorific value MJ/kg', 'uk' => 'Теплота згорання МДж/кг'],
            'norm' => '>14.65',
            'value' => '17.387',
        ],
        'sulfur' => [
            'name' => ['en' => 'Sulfur content', 'uk' => 'Вміст сірки, %'],
            'norm' => '-',
            'value' => '0.24%',
        ],
        'radionuclides' => [
            'name' => ['en' => 'Radionuclide contamination', 'uk' => 'Забруднення радіонуклідами'],
            'norm' => 'не нормується',
            'value' => 'не виявлено',
        ],
    ];

    public function mount($slug): void
    {
        $this->url = $this->fetchUrl(
            $slug,
            (new Product)->getMorphClass(),
            [
                'element.media',
                'element.variants.basePrices.currency',
                'element.variants.basePrices.priceable',
                'element.variants.values.option',
            ]
        );

        if (!$this->url) {
            abort(404);
        }

        $this->selectedOptionValues = $this->productOptions->mapWithKeys(function ($data) {
            return [$data['option']->id => $data['values']->first()->id];
        })->toArray();
    }

    public function getVariantProperty(): ProductVariant
    {
        return $this->product->variants->first(function ($variant) {
            return !$variant->values->pluck('id')
                ->diff(
                    collect($this->selectedOptionValues)->values()
                )->count();
        });
    }

    public function getProductOptionValuesProperty(): Collection
    {
        return $this->product->variants->pluck('values')->flatten();
    }

    public function getProductOptionsProperty(): Collection
    {
        return $this->productOptionValues->unique('id')->groupBy('product_option_id')
            ->map(function ($values) {
                return [
                    'option' => $values->first()->option,
                    'values' => $values,
                ];
            })->values();
    }

    public function getProductProperty(): Product
    {
        return $this->url->element;
    }

    public function getImagesProperty(): Collection
    {
        return $this->product->media->sortBy('order_column');
    }

    public function getImageProperty(): ?Media
    {
        if (count($this->variant->images)) {
            return $this->variant->images->first();
        }

        if ($primary = $this->images->first(fn ($media) => $media->getCustomProperty('primary'))) {
            return $primary;
        }

        return $this->images->first();
    }

    public function getAttributesProperty(): array
    {
        $attributes = [];
        $locale = app()->getLocale();

        foreach ($this->displayAttributes as $handle) {
            $value = $this->product->translateAttribute($handle);
            $attributes[$handle] = [
                'name' => $this->productAttributes[$handle][$locale] ?? $this->productAttributes[$handle]['en'],
                'value' => $value ?: 'N/A',
            ];
        }

        return $attributes;
    }

    public function getDetailedAttributesProperty(): array
    {
        $locale = app()->getLocale();
        $detailedAttributes = [];

        foreach ($this->detailedAttributes as $key => $data) {
            $name = is_array($data['name']) ? ($data['name'][$locale] ?? $data['name']['en']) : $data['name'];
            $value = $data['value'] ?? ($this->product->translateAttribute($key) ?: 'N/A');
            $norm = $data['norm'] ?? $value;

            $detailedAttributes[$key] = [
                'name' => $name,
                'norm' => $norm,
                'value' => $value,
            ];
        }

        return $detailedAttributes;
    }

    public function getSimilarProductsProperty(): Collection
    {
        if (!$this->product->category) {
            return collect([]);
        }

        return $this->product->category->products()
            ->where('id', '!=', $this->product->id)
            ->with([
                'media',
                'variants.basePrices.currency',
                'variants.basePrices.priceable',
            ])
            ->take(4)
            ->get();
    }

    public function incrementQuantity(): void
    {
        $this->quantity++;
    }

    public function decrementQuantity(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function buyNow(): \Illuminate\Http\RedirectResponse
    {
        Cart::add($this->variant, $this->quantity);
        return redirect()->route('checkout');
    }

    public function render(): View
    {
        return view('livewire.product-page');
    }
}
