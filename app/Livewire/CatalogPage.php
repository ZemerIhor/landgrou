<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Lunar\Models\Product;
use Lunar\Models\Collection;
use Illuminate\Support\Facades\Log;

class CatalogPage extends Component
{
    use WithPagination;

    public $perPage = 12;
    public $category = null;
    public $priceMin = null;
    public $priceMax = null;
    public $attribute = null;

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['category', 'priceMin', 'priceMax', 'attribute'])) {
            $this->applyFilters();
        }
    }

    public function render()
    {
        $locale = app()->getLocale();

        try {
            $productsQuery = Product::where('status', 'published')
                ->with(['variants', 'thumbnail', 'collections']);

            // Фильтр по категории
            if ($this->category) {
                $productsQuery->whereHas('collections', function ($query) {
                    $query->where('id', $this->category);
                });
            }

            // Фильтр по цене
            if ($this->priceMin || $this->priceMax) {
                $productsQuery->whereHas('variants', function ($query) {
                    if ($this->priceMin) {
                        $query->where('price', '>=', (int)($this->priceMin * 100)); // Lunar хранит цену в центах
                    }
                    if ($this->priceMax) {
                        $query->where('price', '<=', (int)($this->priceMax * 100)); // Lunar хранит цену в центах
                    }
                });
            }

            // Фильтр по атрибутам (заглушка)
            if ($this->attribute) {
                // Логика фильтрации по атрибутам будет добавлена позже
                Log::info('Attribute filter applied', ['attribute' => $this->attribute]);
            }

            $products = $productsQuery->paginate($this->perPage);

            Log::info('Catalog Page Products', [
                'products' => $products->toArray(),
                'filters' => [
                    'category' => $this->category,
                    'priceMin' => $this->priceMin,
                    'priceMax' => $this->priceMax,
                    'attribute' => $this->attribute,
                ],
            ]);

            return view('livewire.catalog-page', [
                'products' => $products,
                'locale' => $locale,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading Catalog Page', ['error' => $e->getMessage(), 'filters' => [
                'category' => $this->category,
                'priceMin' => $this->priceMin,
                'priceMax' => $this->priceMax,
                'attribute' => $this->attribute,
            ]]);
            // Возвращаем пустой пагинатор вместо коллекции
            return view('livewire.catalog-page', [
                'products' => Product::query()->paginate($this->perPage),
                'locale' => $locale,
            ])->with('error', __('Помилка завантаження каталогу: ') . $e->getMessage());
        }
    }
}
