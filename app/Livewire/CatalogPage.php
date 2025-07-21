<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Brand;
use Lunar\Models\Currency;
use Lunar\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class CatalogPage extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $brands = [];
    public $priceMax = null;
    public $sort = 'name_asc';
    public $view = 'grid';
    public $locale;
    public $currency;

    protected $listeners = [
        'updatePriceMax' => 'updatePriceMax',
    ];

    public function mount(): void
    {
        $this->locale = app()->getLocale();
        $this->currency = Currency::where('code', config('lunar.currency'))->first() ?? Currency::first();

        // Read query parameters (convert price_max from UAH to cents)
        $this->priceMax = Request::query('price_max') ? (float) Request::query('price_max') * 100 : null;
        $this->brands = Request::query('brands', []);
        $this->sort = Request::query('sort', 'name_asc');
        $this->view = Request::query('view', 'grid');

        Log::info('Catalog Page Mounted', [
            'locale' => $this->locale,
            'currency' => $this->currency ? $this->currency->code : 'not found',
            'minPrice' => $this->priceRange['min'],
            'maxPrice' => $this->priceRange['max'],
            'query_params' => [
                'price_max' => $this->priceMax,
                'brands' => $this->brands,
                'sort' => $this->sort,
                'view' => $this->view,
            ],
        ]);
    }

    public function updatePriceMax($value)
    {
        $this->priceMax = (float) $value * 100; // Convert UAH to cents
        $this->updateUrl();
    }

    public function applyFilters()
    {
        if ($this->priceMax !== null) {
            $this->priceMax = max(0, (float) $this->priceMax);
            if ($this->priceMax > $this->priceRange['max'] * 100) {
                $this->priceMax = $this->priceRange['max'] * 100;
            }
        }

        $this->resetPage();
        $this->updateUrl();

        Log::info('Filters Applied', [
            'brands' => $this->brands,
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
        $this->priceMax = null;
        $this->applyFilters();
    }

    public function clearAllFilters()
    {
        $this->brands = [];
        $this->priceMax = null;
        $this->applyFilters();
    }

    public function setView($view)
    {
        $this->view = $view;
        $this->updateUrl();
        Log::info('View Changed', ['view' => $this->view]);
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
        $this->updateUrl();
        Log::info('Sort Changed', ['sort' => $this->sort]);
    }

    protected function updateUrl()
    {
        $query = array_filter([
            'price_max' => $this->priceMax ? $this->priceMax / 100 : null, // Convert back to UAH for URL
            'brands' => !empty($this->brands) ? $this->brands : null,
            'sort' => $this->sort !== 'name_asc' ? $this->sort : null,
            'view' => $this->view !== 'grid' ? $this->view : null,
        ]);

        $url = route('catalog.view', ['locale' => $this->locale], false);
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $this->redirect($url, navigate: true);
    }

    public function getProductsProperty()
    {
        $productsQuery = Product::where('status', 'published')
            ->with(['variants', 'thumbnail', 'brand', 'variants.prices']);

        if (!empty($this->brands)) {
            $productsQuery->whereIn('brand_id', $this->brands);
        }

        if ($this->priceMax !== null) {
            $productsQuery->whereHas('variants', function ($query) {
                $query->whereHas('prices', function ($priceQuery) {
                    $priceQuery->where('currency_id', $this->currency->id)
                        ->where('price', '<=', (float) $this->priceMax); // Price in cents
                });
            });
            Log::info('Price Filter Applied', ['priceMax' => $this->priceMax]);
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
                    ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->join('lunar_prices', function ($join) {
                        $join->on('lunar_product_variants.id', '=', 'lunar_prices.priceable_id')
                            ->where('lunar_prices.priceable_type', 'Lunar\Models\ProductVariant')
                            ->where('lunar_prices.currency_id', '=', $this->currency->id);
                    })
                    ->groupBy('lunar_products.id') // Group by product to avoid duplicates
                    ->orderByRaw('MIN(lunar_prices.price) ASC');
                break;
            case 'price_desc':
                $productsQuery->select('lunar_products.*')
                    ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->join('lunar_prices', function ($join) {
                        $join->on('lunar_product_variants.id', '=', 'lunar_prices.priceable_id')
                            ->where('lunar_prices.priceable_type', 'Lunar\Models\ProductVariant')
                            ->where('lunar_prices.currency_id', '=', $this->currency->id);
                    })
                    ->groupBy('lunar_products.id') // Group by product to avoid duplicates
                    ->orderByRaw('MAX(lunar_prices.price) DESC');
                break;
        }

        $products = $productsQuery->distinct()->paginate($this->perPage);

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
        return Cache::remember('price_range_' . $this->currency->id, now()->addHours(1), function () {
            $minPrice = Product::where('status', 'published')
                ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                ->join('lunar_prices', function ($join) {
                    $join->on('lunar_product_variants.id', '=', 'lunar_prices.priceable_id')
                        ->where('lunar_prices.priceable_type', 'Lunar\Models\ProductVariant')
                        ->where('lunar_prices.currency_id', '=', $this->currency->id);
                })
                ->min('lunar_prices.price') ?? 0;

            $maxPrice = Product::where('status', 'published')
                ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                ->join('lunar_prices', function ($join) {
                    $join->on('lunar_product_variants.id', '=', 'lunar_prices.priceable_id')
                        ->where('lunar_prices.priceable_type', 'Lunar\Models\ProductVariant')
                        ->where('lunar_prices.currency_id', '=', $this->currency->id);
                })
                ->max('lunar_prices.price') ?? 100000; // Default in cents

            Log::info('Price Range Calculated', [
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
            ]);

            return [
                'min' => $minPrice / 100, // Convert to UAH for front-end
                'max' => $maxPrice / 100, // Convert to UAH for front-end
            ];
        });
    }

    public function render(): View
    {
        try {
            Log::info('Catalog Page Rendering', [
                'products_count' => $this->products->total(),
                'filters' => [
                    'brands' => $this->brands,
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
                    'priceMax' => $this->priceMax,
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => Product::where('status', 'published')->paginate($this->perPage),
                'availableBrands' => Brand::whereHas('products')->get(),
                'minPrice' => 0,
                'maxPrice' => 1000,
                'locale' => $this->locale,
                'currency' => $this->currency,
            ])->with('error', __('messages.catalog.error') . ': ' . $e->getMessage());
        }
    }
}
