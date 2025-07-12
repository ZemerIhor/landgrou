<main class="self-stretch px-12 pt-14 bg-zinc-100 max-md:px-5">
    <!-- Breadcrumbs Navigation -->
    <nav class="flex flex-wrap gap-2 items-center w-full text-xs font-semibold whitespace-nowrap min-h-[34px] max-md:max-w-full" aria-label="Breadcrumb">
        <div class="flex gap-2 items-center self-stretch py-2 my-auto text-neutral-400">
            <a href="/" class="self-stretch my-auto text-neutral-400 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                {{ __('Главная') }}
            </a>
        </div>
        <div class="flex gap-2 items-center self-stretch py-2 my-auto text-zinc-800">
            <div class="flex flex-col justify-center self-stretch my-auto w-1.5" aria-hidden="true">
                <span class="text-zinc-800">/</span>
            </div>
            <span class="self-stretch my-auto text-zinc-800" aria-current="page">
                {{ __('Каталог') }}
            </span>
        </div>
    </nav>

    <!-- Page Title -->
    <header>
        <h1 class="text-2xl font-bold leading-tight text-black max-md:max-w-full">
            {{ __('Каталог продуктов') }}
        </h1>
    </header>

    <!-- Filter Controls and Results Count -->
    <section class="flex flex-wrap gap-2 items-center w-full min-h-10 max-md:max-w-full" aria-label="Фильтры и сортировка">
        <!-- Results Count -->
        <div class="flex gap-1 items-center self-stretch my-auto text-xs font-semibold text-black whitespace-nowrap">
            <span class="self-stretch my-auto">{{ __('Найдено') }}</span>
            <span class="self-stretch my-auto">{{ $products->total() }}</span>
            <span class="self-stretch my-auto">{{ __('товаров') }}</span>
        </div>

        <!-- Active Filter Tags -->
        <div class="flex flex-wrap flex-1 shrink gap-0.5 items-center self-stretch my-auto text-xs font-bold leading-tight text-white basis-8 min-w-60 max-md:max-w-full" role="group" aria-label="Активные фильтры">
            @if (!empty($brands))
                @foreach ($brands as $brandId)
                    @if ($brand = $availableBrands->find($brandId))
                        <button wire:click="removeBrand({{ $brandId }})" class="flex gap-1 items-center self-stretch pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Удалить фильтр: {{ $brand->translateAttribute('name') ?? $brand->name ?? '' }}">
                            <span class="self-stretch my-auto text-white">{{ $brand->translateAttribute('name') ?? $brand->name ?? '' }}</span>
                            <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ba94ac2e61738f897029abe123360249f0f65ef9?placeholderIfAbsent=true" class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square" alt="Удалить фильтр" />
                        </button>
                    @endif
                @endforeach
            @endif
            @if ($priceMin || $priceMax)
                <button wire:click="clearPrice" class="flex gap-1 items-center self-stretch pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Удалить фильтр: Цена">
                    <span class="self-stretch my-auto text-white">{{ __('Цена') }}: {{ number_format($priceMin ?? 0, 2) }}-{{ number_format($priceMax ?? '∞', 2) }} UAH</span>
                    <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ba94ac2e61738f897029abe123360249f0f65ef9?placeholderIfAbsent=true" class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square" alt="Удалить фильтр" />
                </button>
            @endif
            @if (!empty($brands) || $priceMin || $priceMax)
                <button wire:click="clearAllFilters" class="flex gap-1 items-center self-stretch pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-red-500 min-h-10 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Сбросить все фильтры">
                    <span class="self-stretch my-auto text-white">{{ __('Сбросить все') }}</span>
                    <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ba94ac2e61738f897029abe123360249f0f65ef9?placeholderIfAbsent=true" class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square" alt="Сбросить фильтры" />
                </button>
            @endif
        </div>

        <!-- Sort Dropdown -->
        <div class="relative">
            <select wire:model.live="sort" class="flex gap-4 items-center self-stretch px-4 my-auto text-sm font-bold leading-tight rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 w-[180px] hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Сортировка">
                <option value="name_asc">{{ __('Название А-Я') }}</option>
                <option value="name_desc">{{ __('Название Я-А') }}</option>
                <option value="price_asc">{{ __('Цена: низкая к высокой') }}</option>
                <option value="price_desc">{{ __('Цена: высокая к низкой') }}</option>
            </select>
        </div>

        <!-- View Toggle -->
        <div class="flex gap-1 items-center self-stretch p-1 my-auto rounded-2xl bg-neutral-200 min-h-10" role="group" aria-label="Вид отображения">
            <button wire:click="setView('grid')" class="flex gap-2.5 items-center self-stretch p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 {{ $view === 'grid' ? 'bg-green-600 text-white' : 'bg-neutral-200 text-zinc-800' }}" aria-label="Вид сетки" aria-pressed="{{ $view === 'grid' ? 'true' : 'false' }}">
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">🟦</div>
            </button>
            <button wire:click="setView('list')" class="flex gap-2.5 items-center self-stretch p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 {{ $view === 'list' ? 'bg-green-600 text-white' : 'bg-neutral-200 text-zinc-800' }}" aria-label="Вид списка" aria-pressed="{{ $view === 'list' ? 'true' : 'false' }}">
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">📄</div>
            </button>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="flex flex-wrap gap-2 items-start pt-2 w-full max-md:max-w-full">
        <!-- Filters Sidebar -->
        <aside class="rounded-3xl bg-neutral-200 min-w-60 w-[289px]" aria-label="Фильтры товаров">
            <!-- Brand Filter -->
            <section class="w-full rounded-2xl text-zinc-800">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight rounded-2xl bg-neutral-200 min-h-10 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-expanded="true" aria-controls="brand-options">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Бренд') }}</span>
                    <div class="flex shrink-0 self-stretch my-auto w-4 h-4 rotate-[-3.1415925661670165rad]" aria-hidden="true"></div>
                </button>
                <div id="brand-options" class="flex items-start pr-0.5 pb-2 w-full text-xs font-semibold whitespace-nowrap rounded-2xl bg-neutral-200">
                    <fieldset class="flex-1 shrink w-full basis-0 min-w-60">
                        <legend class="sr-only">{{ __('Бренд') }}</legend>
                        @foreach ($availableBrands as $brand)
                            <div class="flex gap-2 items-center px-4 py-2 w-full min-h-10">
                                <input type="checkbox" id="brand-{{ $brand->id }}" wire:model.debounce.500ms="brands" value="{{ $brand->id }}" class="w-6 h-6 text-green-600 bg-white border-neutral-400 rounded focus:ring-green-500 focus:ring-2" />
                                <label for="brand-{{ $brand->id }}" class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800 cursor-pointer">{{ $brand->translateAttribute('name') ?? $brand->name ?? '' }}</label>
                            </div>
                        @endforeach
                    </fieldset>
                </div>
            </section>

            <!-- Separator -->
            <div class="px-4 w-full">
                <hr class="w-full rounded-sm bg-zinc-300 min-h-px border-0" />
            </div>

            <!-- Price Filter (Improved Dual Range Slider) -->
            <section class="py-4 w-full rounded-2xl bg-neutral-200">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight whitespace-nowrap rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-expanded="true" aria-controls="price-filter">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Цена') }}</span>
                    <div class="flex shrink-0 self-stretch my-auto w-4 h-4 rotate-[-3.1415925661670165rad]" aria-hidden="true"></div>
                </button>
                <div id="price-filter" class="flex flex-col gap-2 items-start mx-auto my-0 w-[280px] max-md:w-full max-md:max-w-[280px]">
                    <!-- Price Display -->
                    <header class="flex gap-2 justify-center items-center px-4 w-[280px] max-md:w-full max-md:max-w-[280px]" aria-label="Диапазон цен">
                        <span class="text-xs font-bold leading-5 text-zinc-800" aria-label="Минимальная цена">
                            {{ number_format(($priceMin ?? $minPrice), 2) }} UAH
                        </span>
                        <span class="text-xs font-bold leading-5 text-zinc-800" aria-hidden="true">-</span>
                        <span class="text-xs font-bold leading-5 text-zinc-800" aria-label="Максимальная цена">
                            {{ number_format(($priceMax ?? $maxPrice), 2) }} UAH
                        </span>
                    </header>

                    <!-- Range Slider -->
                    <span class="multi-range relative h-8 w-[280px] max-md:w-full max-md:max-w-[280px]" role="group" aria-label="Фильтр цен">
                        <input type="range" wire:model.live.debounce.500ms="priceMin" min="{{ $minPrice }}" max="{{ $maxPrice }}" step="0.01" id="priceMin" aria-label="Минимальная цена" aria-valuemin="{{ $minPrice }}" aria-valuemax="{{ $maxPrice }}" aria-valuenow="{{ $priceMin ?? $minPrice }}">
                        <input type="range" wire:model.live.debounce.500ms="priceMax" min="{{ $minPrice }}" max="{{ $maxPrice }}" step="0.01" id="priceMax" aria-label="Максимальная цена" aria-valuemin="{{ $minPrice }}" aria-valuemax="{{ $maxPrice }}" aria-valuenow="{{ $priceMax ?? $maxPrice }}">
                    </span>
                </div>
            </section>

            <!-- Separator -->
            <div class="px-4 w-full">
                <hr class="w-full rounded-sm bg-zinc-300 min-h-px border-0" />
            </div>

            <!-- Apply Button -->
            <div class="flex gap-2 items-start p-4 w-full text-base font-bold leading-snug text-green-600 whitespace-nowrap">
                <button wire:click="applyFilters" class="flex flex-1 shrink gap-2 justify-center items-center px-6 py-2.5 w-full rounded-2xl border-2 border-green-600 border-solid basis-0 min-h-11 min-w-60 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                    <span class="self-stretch my-auto text-green-600">{{ __('Применить') }}</span>
                </button>
            </div>
        </aside>

        <!-- Product Grid -->
        <section class="flex-1 shrink basis-0 min-w-60 max-md:max-w-full" aria-label="Список товаров">
            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $error }}
                </div>
            @endif

            <!-- Grid or List view based on $view -->
            <div class="{{ $view == 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6' : 'flex flex-col gap-6' }}">
                @forelse ($products as $product)
                    <article wire:key="product-{{ $product->id }}" class="overflow-hidden rounded-3xl bg-neutral-200 min-w-60">
                        <div class="flex relative flex-col w-full min-h-[153px]">
                            @if ($product->thumbnail)
                                <div class="flex overflow-hidden absolute top-2/4 left-2/4 z-0 flex-col px-1.5 max-w-full -translate-x-2/4 -translate-y-2/4 h-[163px] w-[300px]">
                                    <a href="{{ route('product.view', $product->defaultUrl->slug ?? '') }}">
                                        <img src="{{ $product->thumbnail->getUrl() }}"
                                             alt="{{ $product->attribute_data['name']->getValue($locale) ?? 'Product' }}"
                                             class="object-contain w-full aspect-[1.77]" />
                                    </a>
                                </div>
                            @endif
                            <div class="flex z-0 gap-2.5 self-end w-14 min-h-14" aria-hidden="true"></div>
                        </div>
                        <div class="p-4 w-full">
                            <div class="w-full text-zinc-800">
                                <h3 class="text-base font-bold leading-5 text-zinc-800">
                                    <a href="{{ route('product.view', $product->defaultUrl->slug ?? '') }}">
                                        {{ $product->translateAttribute('name') }}
                                    </a>
                                </h3>
                                <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">
                                    {{ strip_tags($product->translateAttribute('description')) }}
                                </p>
                                @if ($product->brand)
                                    <p class="text-xs mt-1">{{ __('Бренд') }}: {{ $product->brand->translateAttribute('name') ?? $product->brand->name ?? 'N/A' }}</p>
                                @endif
                            </div>
                            <div class="flex gap-10 justify-between items-end mt-2 w-full text-base font-bold">
                                <span class="leading-tight text-zinc-800">
                                    <x-product-price :product="$product" />
                                </span>
                                <div class="mt-3">
                                    <livewire:components.add-to-cart :purchasable="$product->variants->first()" :key="'add-to-cart-' . $product->id" />
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <p>{{ __('Нет товаров по выбранным параметрам.') }}</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <nav class="flex flex-wrap gap-2 justify-center items-center pt-10 w-full max-md:max-w-full" aria-label="Навигация по страницам">
                {{ $products->links() }}
            </nav>
        </section>
    </div>

    <style>
        input[type=range] {
            box-sizing: border-box;
            appearance: none;
            width: 280px;
            margin: 0;
            padding: 0;
            overflow: hidden;
            border: 0;
            border-radius: 4px;
            outline: none;
            background: transparent;
            pointer-events: none;
            height: 8px;
        }

        input[type=range]::-webkit-slider-runnable-track {
            height: 8px;
            background: #e4e4e7; /* neutral-200 */
            border-radius: 4px;
        }

        input[type=range]::-webkit-slider-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background-color: #16a34a; /* green-600 */
            cursor: pointer;
            appearance: none;
            pointer-events: all;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            margin-top: -6px;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        input[type=range]:active::-webkit-slider-thumb {
            transform: scale(1.2);
        }

        .multi-range {
            position: relative;
            height: 40px;
            background: linear-gradient(
            to right,
            #e4e4e7 0%,
            #e4e4e7 {{ ($priceMin ?? $minPrice) / $maxPrice * 100 }}%,
            #16a34a {{ ($priceMin ?? $minPrice) / $maxPrice * 100 }}%,
            #16a34a {{ ($priceMax ?? $maxPrice) / $maxPrice * 100 }}%,
            #e4e4e7 {{ ($priceMax ?? $maxPrice) / $maxPrice * 100 }}%,
            #e4e4e7 100%
            );
            border-radius: 4px;
        }

        .multi-range input[type=range] {
            position: absolute;
            top: 16px;
        }

        .multi-range input[type=range]:nth-child(2) {
            background: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const priceMinSlider = document.querySelector('#priceMin');
            const priceMaxSlider = document.querySelector('#priceMax');

            if (priceMinSlider && priceMaxSlider) {
                const minGap = 4; // Минимальная разница между ползунками
                const minValue = parseFloat(priceMinSlider.min);
                const maxValue = parseFloat(priceMaxSlider.max);

                function updateSliders() {
                    let priceMinVal = parseFloat(priceMinSlider.value);
                    let priceMaxVal = parseFloat(priceMaxSlider.value);

                    // Предотвращаем пересечение ползунков
                    if (priceMaxVal - priceMinVal < minGap) {
                        if (this === priceMinSlider) {
                            priceMinSlider.value = Math.min(priceMaxVal - minGap, maxValue - minGap);
                        } else {
                            priceMaxSlider.value = Math.max(priceMinVal + minGap, minGap);
                        }
                    }

                    // Обновляем значения в Livewire
                    Livewire.emit('updatePriceMin', priceMinSlider.value);
                    Livewire.emit('updatePriceMax', priceMaxSlider.value);
                }

                priceMinSlider.addEventListener('input', updateSliders);
                priceMaxSlider.addEventListener('input', updateSliders);
            }
        });
    </script>
</main>
