<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Product;
use Lunar\Models\Collection;
use Lunar\Models\Currency;
use Illuminate\Support\Facades\Log;

class CatalogPage extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $categories = [];
    public $priceMin = null;
    public $priceMax = null;
    public $weights = [];
    public $sort = 'name_asc';
    public $view = 'grid';
    public $availableWeights = ['10 kg', '25 kg', '40 kg', '100 kg', '500 kg', '1 t'];

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function removeCategory($id)
    {
        $this->categories = array_diff($this->categories, [$id]);
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
        if (in_array($property, ['categories', 'priceMin', 'priceMax', 'weights', 'sort'])) {
            $this->applyFilters();
        }
    }

    public function render()
    {
        $locale = app()->getLocale();
        $currency = Currency::where('code', config('lunar.currency'))->first() ?? Currency::first();

        try {
            $productsQuery = Product::where('status', 'published')
                ->with(['variants', 'thumbnail', 'collections', 'variants.prices']);

            // Фильтр по категориям
            if (!empty($this->categories)) {
                $productsQuery->whereHas('collections', function ($query) {
                    $query->whereIn('id', $this->categories);
                });
            }

            // Фильтр по цене
            if ($this->priceMin || $this->priceMax) {
                $productsQuery->whereHas('variants.prices', function ($query) use ($currency) {
                    $query->where('currency_id', $currency->id);
                    if ($this->priceMin) {
                        $query->where('price', '>=', (int)($this->priceMin * 100));
                    }
                    if ($this->priceMax) {
                        $query->where('price', '<=', (int)($this->priceMax * 100));
                    }
                });
            }

            // Фильтр по весу
            if (!empty($this->weights)) {
                $productsQuery->where(function ($query) {
                    foreach ($this->weights as $weight) {
                        $query->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(attribute_data, '$.weight.value')) = ?", [$weight]);
                    }
                });
            }

            // Сортировка
            switch ($this->sort) {
                case 'name_asc':
                    $productsQuery->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(attribute_data, '$.name.value." . $locale . "')) ASC");
                    break;
                case 'name_desc':
                    $productsQuery->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(attribute_data, '$.name.value." . $locale . "')) DESC");
                    break;
                case 'price_asc':
                    $productsQuery->select('lunar_products.*')
                        ->addSelect(\DB::raw("(SELECT MIN(price) FROM lunar_prices WHERE priceable_id = lunar_product_variants.id AND priceable_type = 'Lunar\\Models\\ProductVariant' AND currency_id = {$currency->id} AND lunar_product_variants.product_id = lunar_products.id) as min_price"))
                        ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                        ->orderBy('min_price', 'asc');
                    break;
                case 'price_desc':
                    $productsQuery->select('lunar_products.*')
                        ->addSelect(\DB::raw("(SELECT MAX(price) FROM lunar_prices WHERE priceable_id = lunar_product_variants.id AND priceable_type = 'Lunar\\Models\\ProductVariant' AND currency_id = {$currency->id} AND lunar_product_variants.product_id = lunar_products.id) as max_price"))
                        ->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                        ->orderBy('max_price', 'desc');
                    break;
            }

            $products = $productsQuery->paginate($this->perPage);
            $collections = Collection::whereHas('products')->get();
            $minPrice = \DB::table('lunar_prices')
                    ->where('priceable_type', 'Lunar\\Models\\ProductVariant')
                    ->where('currency_id', $currency->id)
                    ->min('price') / 100;
            $maxPrice = \DB::table('lunar_prices')
                    ->where('priceable_type', 'Lunar\\Models\\ProductVariant')
                    ->where('currency_id', $currency->id)
                    ->max('price') / 100;

            Log::info('Catalog Page Products', [
                'products' => $products->toArray(),
                'filters' => [
                    'categories' => $this->categories,
                    'priceMin' => $this->priceMin,
                    'priceMax' => $this->priceMax,
                    'weights' => $this->weights,
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => $products,
                'collections' => $collections,
                'availableWeights' => $this->availableWeights,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'locale' => $locale,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading Catalog Page', [
                'error' => $e->getMessage(),
                'filters' => [
                    'categories' => $this->categories,
                    'priceMin' => $this->priceMin,
                    'priceMax' => $this->priceMax,
                    'weights' => $this->weights,
                    'sort' => $this->sort,
                    'view' => $this->view,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => Product::query()->paginate($this->perPage),
                'collections' => Collection::whereHas('products')->get(),
                'availableWeights' => $this->availableWeights,
                'minPrice' => null,
                'maxPrice' => null,
                'locale' => $locale,
            ])->with('error', __('Помилка завантаження каталогу: ') . $e->getMessage());
        }
    }
}
