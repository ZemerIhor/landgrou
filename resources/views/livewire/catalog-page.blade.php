<div class="container mx-auto py-8">
    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-6 mt-4">{{ __('Каталог продуктів') }}</h1>

    <!-- Фильтры и сортировка -->
    <div class="flex flex-wrap gap-4 mb-6">
        <aside class="w-64 p-4 bg-neutral-100 rounded-2xl">
            <h2 class="text-lg font-semibold mb-2">{{ __('Бренд') }}</h2>
            @foreach ($availableBrands as $brand)
                <label class="flex items-center space-x-2 mb-2 cursor-pointer">
                    <input type="checkbox" wire:model="brands" value="{{ $brand->id }}" class="form-checkbox">
                    <span>{{ $brand->translateAttribute('name') ?? $brand->name ?? '' }}</span>
                </label>
            @endforeach


            <hr class="my-4">

            <h2 class="text-lg font-semibold mb-2">{{ __('Вага') }}</h2>
            @foreach ($availableWeights as $weight)
                <label class="flex items-center space-x-2 mb-2 cursor-pointer">
{{--                    <input type="checkbox" wire:model="weights" value="{{ $weight }}" class="form-checkbox">--}}
{{--                    <span>{{ $weight }}</span>--}}
                </label>
            @endforeach

            <hr class="my-4">

            <h2 class="text-lg font-semibold mb-2">{{ __('Ціна') }}</h2>
            <div class="flex space-x-2">
                <input type="number" wire:model="priceMin" class="w-full border rounded px-2 py-1" placeholder="{{ $minPrice }}">
                <input type="number" wire:model="priceMax" class="w-full border rounded px-2 py-1" placeholder="{{ $maxPrice }}">
            </div>

            <button wire:click="applyFilters" class="mt-4 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                {{ __('Застосувати') }}
            </button>
        </aside>

        <div class="flex-1">
            <div class="flex justify-between items-center mb-4">
                <!-- Сортировка -->
                <select wire:model="sort" class="border rounded px-3 py-2 text-sm">
                    <option value="name_asc">{{ __('Назва А-Я') }}</option>
                    <option value="name_desc">{{ __('Назва Я-А') }}</option>
                    <option value="price_asc">{{ __('Ціна: низька до високої') }}</option>
                    <option value="price_desc">{{ __('Ціна: висока до низької') }}</option>
                </select>

                <!-- Переключение вида -->
                <div class="flex items-center space-x-2">
                    <button wire:click="setView('grid')" class="p-2 border rounded {{ $view === 'grid' ? 'bg-green-600 text-white' : '' }}">
                        🟦
                    </button>
                    <button wire:click="setView('list')" class="p-2 border rounded {{ $view === 'list' ? 'bg-green-600 text-white' : '' }}">
                        📄
                    </button>
                </div>
            </div>

            <!-- Список продуктов -->
            <div class="{{ $view == 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6' : 'flex flex-col gap-6' }}">
                @forelse ($products as $product)
                    <div class="bg-neutral-200 p-4 rounded-2xl">
                        <a href="{{ route('product.view', $product->defaultUrl->slug ?? '') }}">
                            @if ($product->thumbnail)
                                <img src="{{ $product->thumbnail->getUrl() }}"
                                     alt="{{ $product->attribute_data['name']->getValue($locale) ?? 'Product' }}"
                                     class="w-full h-48 object-contain mb-2">
                            @endif

                                <h2 class="text-base font-bold leading-5 text-zinc-800">{{ $product->translateAttribute('name') }}</h2>


                                <div class="p-4 w-full">
                                    <div class="w-full text-zinc-800">
                                        <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">{{ strip_tags($product->translateAttribute('description')) }}</p>
                                    </div>
                                </div>


                                <p class="font-semibold mt-2">
                                <x-product-price :product="$product" />
                            </p>

                            @if ($product->brand)
                                <p class="text-sm mt-1">{{ __('Бренд') }}: {{ $product->brand->translateAttribute('name') ?? $product->brand->name ?? 'N/A' }}</p>
                            @endif


                        </a>

                        <div class="mt-3">
                            <livewire:components.add-to-cart :purchasable="$product->variants->first()" />
                        </div>
                    </div>
                @empty
                    <p>{{ __('Немає товарів за вибраними параметрами.') }}</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
