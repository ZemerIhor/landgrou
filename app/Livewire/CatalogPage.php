<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Collection;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class Catalog extends Component
{
    use WithPagination;

    public array $categories = [];
    public array $weights = [];
    public $priceMin;
    public $priceMax;
    public string $sort = 'name_asc';
    public string $view = 'grid';

    public function mount()
    {
        // Инициализация, если нужно
        Log::info('Catalog component mounted');
    }

    public function removeCategory($categoryId)
    {
        $this->categories = array_filter($this->categories, fn ($id) => $id != $categoryId);
        $this->applyFilters();
    }

    public function removeWeight($weight)
    {
        $this->weights = array_filter($this->weights, fn ($w) => $w != $weight);
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

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query();

        // Фильтр по категориям (collections)
        if (!empty($this->categories)) {
            $query->whereHas('collections', function (Builder $q) {
                $q->whereIn('lunar_collections.id', $this->categories);
            });
        }

        // Фильтр по цене
        if ($this->priceMin || $this->priceMax) {
            $query->whereHas('variants', function (Builder $q) {
                if ($this->priceMin) {
                    $q->where('price', '>=', $this->priceMin * 100); // Предполагаем цену в копейках/центах, как в Lunar
                }
                if ($this->priceMax) {
                    $q->where('price', '<=', $this->priceMax * 100);
                }
            });
        }

        // Фильтр по весу (предполагаем атрибут 'weight' в вариантах)
        if (!empty($this->weights)) {
            $query->whereHas('variants', function (Builder $q) {
                $q->whereIn('weight', $this->weights);
            });
        }

        // Сортировка
        switch ($this->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->orderBy('lunar_product_variants.price', 'asc');
                break;
            case 'price_desc':
                $query->join('lunar_product_variants', 'lunar_products.id', '=', 'lunar_product_variants.product_id')
                    ->orderBy('lunar_product_variants.price', 'desc');
                break;
        }

        // Получить продукты с пагинацией
        $products = $query->paginate(12);

        // Получить коллекции (категории)
        $collections = Collection::where('type', 'category')->get(); // Предполагаем, что категории имеют type 'category'

        // Получить доступные веса (из атрибутов вариантов)
        $availableWeights = ProductVariant::distinct('weight')->pluck('weight')->sort()->toArray();

        // Минимальная и максимальная цена
        $minPrice = ProductVariant::min('price') / 100 ?? 0;
        $maxPrice = ProductVariant::max('price') / 100 ?? 0;

        return view('livewire.catalog', [
            'products' => $products,
            'collections' => $collections,
            'availableWeights' => $availableWeights,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }
}
