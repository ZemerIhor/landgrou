<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Brand;
use Lunar\Models\Currency;
use Lunar\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CatalogPage extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $brands = [];
    public $priceMin = null;
    public $priceMax = null;
    public $weights = [];
    public $sort = 'name_asc';
    public $view = 'grid';
    public $locale;
    public $currency;

    public function mount(): void
    {
        $this->locale = app()->getLocale();
        $this->currency = Currency::where('code', config('lunar.currency'))->first() ?? Currency::first();
    }

    public function getProductsProperty()
    {
        $productsQuery = Product::where('status', 'published')
            ->with(['variants', 'thumbnail', 'brand', 'variants.prices']);

        if (!empty($this->brands)) {
            $productsQuery->whereIn('brand_id', $this->brands);
        }

        if ($this->priceMin || $this->priceMax) {
            $productsQuery->whereHas('variants.prices', function ($query) {
                $query->where('currency_id', $this->currency->id);
                if ($this->priceMin) {
                    $query->where('price', '>=', (int)($this->priceMin * 100));
                }
                if ($this->priceMax) {
                    $query->where('price', '<=', (int)($this->priceMax * 100));
                }
            });
        }

        if (!empty($this->weights)) {
            $productsQuery->where(function ($query) {
                foreach ($this->weights as $weight) {
                    $query->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(attribute_data, '$.packaging.value.{$this->locale}')) = ?", [$weight]);
                }
            });
        }

        switch ($this->sort) {
            case 'name_asc':
                $productsQuery->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(attribute_data, '$.name.value.{$this->locale}')) ASC");
                break;
            case 'name_desc':
                $productsQuery->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(attribute_data, '$.name.value.{$this->locale}')) DESC");
                break;
            case 'price_asc':
                $productsQuery->select('lunar_products.*')
                    ->addSelect(\DB::raw("(SELECT MIN(price) FROM lunar_prices WHERE priceable_id = lunar_product_variants.id AND priceable_type = 'Lunar\\Models\\ProductVariant' AND currency_id = {$this->currency->id} AND lunar_product_variants.product_id = lunar_products.id) as min_price"))
                    ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->orderBy('min_price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->select('lunar_products.*')
                    ->addSelect(\DB::raw("(SELECT MAX(price) FROM lunar_prices WHERE priceable_id = lunar_product_variants.id AND priceable_type = 'Lunar\\Models\\ProductVariant' AND currency_id = {$this->currency->id} AND lunar_product_variants.product_id = lunar_products.id) as max_price"))
                    ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->orderBy('max_price', 'desc');
                break;
        }

        return $productsQuery->paginate($this->perPage);
    }

    public function getAvailableBrandsProperty()
    {
        return Brand::whereHas('products')->get();
    }

    public function getAvailableWeightsProperty()
    {
        return Product::where('status', 'published')
            ->get()
            ->pluck('attribute_data.packaging')
            ->filter()
            ->map(fn ($packaging) => $packaging instanceof \Lunar\FieldTypes\TranslatedText ? $packaging->getValue($this->locale) : $packaging)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    public function getPriceRangeProperty()
    {
        return [
            'min' => \DB::table('lunar_prices')
                    ->where('priceable_type', 'Lunar\\Models\\ProductVariant')
                    ->where('currency_id', $this->currency->id)
                    ->min('price') / 100 ?? 0,
            'max' => \DB::table('lunar_prices')
                    ->where('priceable_type', 'Lunar\\Models\\ProductVariant')
                    ->where('currency_id', $this->currency->id)
                    ->max('price') / 100 ?? 0,
        ];
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function removeBrand($id)
    {
        $this->brands = array_diff($this->brands, [$id]);
        $this->applyFilters();
    }

    public function removeWeight($weight)
    {
        $this->weights = array_diff($this->weights, [$weight]);
        $this->applyFilters();
    }

    public function clearPrice()
    {
        $this->priceMin = null;
        $this->priceMax = null;
        $this->applyFilters();
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function updated($property)
    {
        if (in_array($property, ['brands', 'priceMin', 'priceMax', 'weights', 'sort'])) {
            $this->applyFilters();
        }
    }

    public function render(): View
    {
        try {
            Log::info('Catalog Page Products', [
                'products' => $this->products->toArray(),
                'filters' => [
                    'brands' => $this->brands,
                    'priceMin' => $this->priceMin,
                    'priceMax' => $this->priceMax,
                    'weights' => $this->weights,
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => $this->products,
                'availableBrands' => $this->availableBrands,
                'availableWeights' => $this->availableWeights,
                'minPrice' => $this->priceRange['min'],
                'maxPrice' => $this->priceRange['max'],
                'locale' => $this->locale,
                'currency' => $this->currency,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading Catalog Page', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'filters' => [
                    'brands' => $this->brands,
                    'priceMin' => $this->priceMin,
                    'priceMax' => $this->priceMax,
                    'weights' => $this->weights,
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => Product::where('status', 'published')->paginate($this->perPage),
                'availableBrands' => Brand::whereHas('products')->get(),
                'availableWeights' => [],
                'minPrice' => null,
                'maxPrice' => null,
                'locale' => $this->locale,
                'currency' => $this->currency,
            ])->with('error', __('messages.catalog.error') . ': ' . $e->getMessage());
        }
    }
}
