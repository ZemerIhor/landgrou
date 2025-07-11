<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Brand;
use Lunar\Models\Currency;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CatalogPage extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $brands = [];
    public $priceMin = null;
    public $priceMax = null;
    public $sort = 'name_asc';
    public $view = 'grid';
    public $locale;
    public $currency;

    public function mount(): void
    {
        $this->locale = app()->getLocale();
        $this->currency = Currency::where('code', config('lunar.currency'))->first() ?? Currency::first();
        Log::info('Catalog Page Mounted', [
            'locale' => $this->locale,
            'currency' => $this->currency->code,
        ]);
    }

    public function getProductsProperty()
    {
        $productsQuery = Product::where('status', 'published')
            ->with(['variants', 'thumbnail', 'brand', 'variants.prices']);

        if (!empty($this->brands)) {
            $productsQuery->whereIn('brand_id', $this->brands);
        }

        if ($this->priceMin !== null || $this->priceMax !== null) {
            $productsQuery->whereHas('variants', function ($query) {
                $query->whereHas('prices', function ($priceQuery) {
                    $priceQuery->where('currency_id', $this->currency->id);

                    // Ensure prices are treated as decimals (UAH)
                    $priceMin = $this->priceMin !== null ? max(0, (float) $this->priceMin) : 0;
                    $priceMax = $this->priceMax !== null ? max(0, (float) $this->priceMax) : PHP_INT_MAX;

                    $priceQuery->whereBetween('price', [$priceMin, $priceMax]);
                });
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
                $productsQuery->select('lunar_products.*', \DB::raw('MIN(lunar_prices.price) as min_price'))
                    ->leftJoin('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->leftJoin('lunar_prices', function ($join) {
                        $join->on('lunar_product_variants.id', '=', 'lunar_prices.priceable_id')
                            ->where('lunar_prices.priceable_type', 'Lunar\Models\ProductVariant')
                            ->where('lunar_prices.currency_id', '=', $this->currency->id);
                    })
                    ->groupBy(
                        'lunar_products.id',
                        'lunar_products.status',
                        'lunar_products.brand_id',
                        'lunar_products.attribute_data',
                        'lunar_products.created_at',
                        'lunar_products.updated_at',
                        'lunar_products.deleted_at'
                    )
                    ->orderBy('min_price', 'ASC');
                break;
            case 'price_desc':
                $productsQuery->select('lunar_products.*', \DB::raw('MAX(lunar_prices.price) as max_price'))
                    ->leftJoin('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->leftJoin('lunar_prices', function ($join) {
                        $join->on('lunar_product_variants.id', '=', 'lunar_prices.priceable_id')
                            ->where('lunar_prices.priceable_type', 'Lunar\Models\ProductVariant')
                            ->where('lunar_prices.currency_id', '=', $this->currency->id);
                    })
                    ->groupBy(
                        'lunar_products.id',
                        'lunar_products.status',
                        'lunar_products.brand_id',
                        'lunar_products.attribute_data',
                        'lunar_products.created_at',
                        'lunar_products.updated_at',
                        'lunar_products.deleted_at'
                    )
                    ->orderBy('max_price', 'DESC');
                break;
        }

        $products = $productsQuery->paginate($this->perPage);

        Log::info('Products Retrieved', [
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'items' => array_map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->translateAttribute('name'),
                    'prices' => $product->variants->map(function ($variant) {
                        return $variant->prices->map(function ($price) {
                            return [
                                'currency_id' => $price->currency_id,
                                'price' => $price->price,
                            ];
                        })->toArray();
                    })->toArray(),
                ];
            }, $products->items()),
        ]);

        return $products;
    }

    public function getAvailableBrandsProperty()
    {
        return Brand::whereHas('products')->get();
    }

    public function getPriceRangeProperty()
    {
        $minPrice = \DB::table('lunar_prices')
            ->where('priceable_type', 'Lunar\Models\ProductVariant')
            ->where('currency_id', $this->currency->id)
            ->min('price') ?? 0;

        $maxPrice = \DB::table('lunar_prices')
            ->where('priceable_type', 'Lunar\Models\ProductVariant')
            ->where('currency_id', $this->currency->id)
            ->max('price') ?? 0;

        return [
            'min' => floor($minPrice),
            'max' => ceil($maxPrice),
        ];
    }

    public function applyFilters()
    {
        // Validate price inputs
        if ($this->priceMin !== null && $this->priceMin < 0) {
            $this->priceMin = null;
        }
        if ($this->priceMax !== null && $this->priceMax < 0) {
            $this->priceMax = null;
        }
        if ($this->priceMin !== null && $this->priceMax !== null && $this->priceMin > $this->priceMax) {
            [$this->priceMin, $this->priceMax] = [$this->priceMax, $this->priceMin];
        }

        $this->resetPage();
        Log::info('Filters Applied', [
            'brands' => $this->brands,
            'priceMin' => $this->priceMin,
            'priceMax' => $this->priceMax,
            'sort' => $this->sort,
            'view' => $this->view,
        ]);
    }

    public function removeBrand($id)
    {
        $this->brands = array_diff($this->brands, [$id]);
        $this->applyFilters();
    }

    public function clearPrice()
    {
        $this->priceMin = null;
        $this->priceMax = null;
        $this->applyFilters();
    }

    public function clearAllFilters()
    {
        $this->brands = [];
        $this->priceMin = null;
        $this->priceMax = null;
        $this->applyFilters();
    }

    public function setView($view)
    {
        $this->view = $view;
        Log::info('View Changed', [
            'view' => $this->view,
        ]);
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['brands', 'priceMin', 'priceMax', 'sort'])) {
            Log::info('Property Updated', [
                'property' => $property,
                'value' => $this->$property,
            ]);
            $this->applyFilters();
        }
    }

    public function render(): View
    {
        try {
            Log::info('Catalog Page Rendering', [
                'products_count' => $this->products->total(),
                'filters' => [
                    'brands' => $this->brands,
                    'priceMin' => $this->priceMin,
                    'priceMax' => $this->priceMax,
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => $this->products,
                'availableBrands' => $this->availableBrands,
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
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => Product::where('status', 'published')->paginate($this->perPage),
                'availableBrands' => Brand::whereHas('products')->get(),
                'minPrice' => null,
                'maxPrice' => null,
                'locale' => $this->locale,
                'currency' => $this->currency,
            ])->with('error', __('messages.catalog.error') . ': ' . $e->getMessage());
        }
    }
}
