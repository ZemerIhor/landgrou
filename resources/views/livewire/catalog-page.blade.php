<main class=" container  mx-auto self-stretch pb-14 px-4 md:px-12 max-md:px-5 catalog-page">
    <!-- Breadcrumbs Navigation -->
    <livewire:components.breadcrumbs :currentPage="__('messages.breadcrumbs.catalog')" :items="[]" />

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
            @if ($priceMax)
                <button wire:click="clearPrice" class="flex gap-1 items-center self-stretch pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Удалить фильтр: Цена">
                    <span class="self-stretch my-auto text-white">{{ __('Цена до') }}: {{ number_format($priceMax, 2) }} UAH</span>
                    <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ba94ac2e61738f897029abe123360249f0f65ef9?placeholderIfAbsent=true" class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square" alt="Удалить фильтр" />
                </button>
            @endif
            @if (!empty($brands) || $priceMax)
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
            <button wire:click="setView('grid')" class="flex gap-2.5 items-center self-stretch p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Вид сетки" aria-pressed="{{ $view === 'grid' ? 'true' : 'false' }}">
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-view {{ $view === 'grid' ? 'icon-active' : '' }}">
                        <path d="M22 8.52V3.98C22 2.57 21.36 2 19.77 2H15.73C14.14 2 13.5 2.57 13.5 3.98V8.51C13.5 9.93 14.14 10.49 15.73 10.49H19.77C21.36 10.5 22 9.93 22 8.52Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 19.77V15.73C22 14.14 21.36 13.5 19.77 13.5H15.73C14.14 13.5 13.5 14.14 13.5 15.73V19.77C13.5 21.36 14.14 22 15.73 22H19.77C21.36 22 22 21.36 22 19.77Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 8.52V3.98C10.5 2.57 9.86 2 8.27 2H4.23C2.64 2 2 2.57 2 3.98V8.51C2 9.93 2.64 10.49 4.23 10.49H8.27C9.86 10.5 10.5 9.93 10.5 8.52Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 19.77V15.73C10.5 14.14 9.86 13.5 8.27 13.5H4.23C2.64 13.5 2 14.14 2 15.73V19.77C2 21.36 2.64 22 4.23 22H8.27C9.86 22 10.5 21.36 10.5 19.77Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
            <button wire:click="setView('list')" class="flex gap-2.5 items-center self-stretch p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Вид списка" aria-pressed="{{ $view === 'list' ? 'true' : 'false' }}">
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-view {{ $view === 'list' ? 'icon-active' : '' }}">
                        <path d="M19.9 13.5H4.1C2.6 13.5 2 14.14 2 15.73V19.77C2 21.36 2.6 22 4.1 22H19.9C21.4 22 22 21.36 22 19.77V15.73C22 14.14 21.4 13.5 19.9 13.5Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.9 2H4.1C2.6 2 2 2.64 2 4.23V8.27C2 9.86 2.6 10.5 4.1 10.5H19.9C21.4 10.5 22 9.86 22 8.27V4.23C22 2.64 21.4 2 19.9 2Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="flex flex-wrap gap-2 items-start justify-center pt-2 w-full max-md:max-w-full">
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

            <!-- Price Filter (Single Slider) -->
            <section class="py-4 w-full rounded-2xl bg-neutral-200">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight whitespace-nowrap rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-expanded="true" aria-controls="price-filter">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Цена до') }}</span>
                    <div class="flex shrink-0 self-stretch my-auto w-4 h-4 rotate-[-3.1415925661670165rad]" aria-hidden="true"></div>
                </button>
                <div id="price-filter" class="flex flex-col gap-4 items-start mx-auto my-0 w-[280px] max-md:w-full max-md:max-w-[280px]">
                    <!-- Price Display -->
                    <div class="w-full px-4">
                        <span class="text-xs font-bold leading-5 text-zinc-800" id="price-max-display">
                            {{ __('Цена до') }}: <span>{{ number_format($priceMax ?? $maxPrice, 2) }}</span> UAH
                        </span>
                    </div>
                    <!-- Price Slider -->
                    <div class="w-full px-4">
                        <input type="range"
                               wire:model.debounce.500ms="priceMax"
                               id="price-max"
                               min="{{ $minPrice }}"
                               max="{{ $maxPrice }}"
                               step="{{ ($maxPrice - $minPrice) > 10000 ? 10 : 1 }}"
                               value="{{ $priceMax ?? $maxPrice }}"
                               class="w-full h-2 cursor-pointer"
                               aria-label="Максимальная цена"
                               aria-valuemin="{{ $minPrice }}"
                               aria-valuemax="{{ $maxPrice }}"
                               aria-valuenow="{{ $priceMax ?? $maxPrice }}" />
                    </div>
                    <!-- Manual Input Field -->
                    <div class="w-full px-4">
                        <input type="number"
                               wire:model.debounce.500ms="priceMax"
                               id="price-max-input"
                               class="w-20 px-2 py-1 border rounded text-xs"
                               placeholder="{{ $maxPrice }}"
                               aria-label="Ввести максимальную цену"
                               min="{{ $minPrice }}"
                               max="{{ $maxPrice }}"
                               step="{{ ($maxPrice - $minPrice) > 10000 ? 10 : 1 }}" />
                    </div>
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
                <div class="{{ $view == 'grid' ? 'catalog-grid' : 'catalog-list' }} catalog-page-grid">
                    @forelse ($products as $product)
                        @php
                            $hasValidSlug = false;
                            $slug = null;

                            // Check for valid slug (considering Lunar's URL system)
                            if ($product->defaultUrl && !empty($product->defaultUrl->slug)) {
                                $slug = $product->defaultUrl->slug;
                                $hasValidSlug = is_string($slug) && trim($slug) !== '';
                            } elseif (!empty($product->slug) && is_string($product->slug) && trim($product->slug) !== '') {
                                $slug = $product->slug;
                                $hasValidSlug = true;
                            }

                            $locale = app()->getLocale();
                            $routeParams = ['slug' => $slug];
                            if ($locale !== 'uk') {
                                $routeParams['locale'] = $locale;
                            }

                            $productUrl = $hasValidSlug ? route('product.view', $routeParams, false) : route('home', $locale !== 'uk' ? ['locale' => $locale] : [], false);
                        @endphp

                        <article wire:key="product-{{ $product->id }}" class="overflow-hidden product-card flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 {{ $view == 'grid' ? 'lg:h-[378px] sm:h-[389px]' : '' }}" role="listitem">
                            <div class="flex flex-col justify-between group h-full">
                                <a href="{{ $productUrl }}" wire:navigate class="flex flex-col h-full">
                                    <div class="flex relative flex-col w-full">
                                        <div class="flex overflow-hidden flex-col max-w-full w-full">
                                            @if ($product->thumbnail)
                                                <img src="{{ $product->thumbnail->getUrl() }}"
                                                     alt="{{ $product->translateAttribute('name') }}"
                                                     class="object-cover w-full aspect-[1.77] transition-transform duration-300 group-hover:scale-105"/>
                                            @else
                                                <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/d7f2f96fb365d97b578a2cfa0ccb76eaba272ebd?placeholderIfAbsent=true"
                                                     alt="Изображение-заглушка"
                                                     class="object-contain w-full aspect-[1.77]"/>
                                            @endif
                                        </div>
                                        <div class="absolute top-0 right-0 flex z-0 pt-2 pr-2" aria-hidden="true">
                                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M27.8029 23.6143L27.8029 8.19658L8.19616 27.8033L16.8665 19.133C20.8858 15.1137 27.7597 17.9304 27.8029 23.6143Z" fill="white"/>
                                                <path d="M27.8029 8.19658L17.5244 8.19658L12.3852 8.19658C18.0721 8.21717 20.9059 15.0936 16.8846 19.1149L8.19616 27.8033L27.8029 8.19658Z" fill="white"/>
                                                <path d="M27.8027 7.19672C28.3548 7.19693 28.8027 7.64463 28.8027 8.19672V28.7534C28.8027 29.3055 28.3548 29.7531 27.8027 29.7534C27.2507 29.7531 26.8038 29.3054 26.8037 28.7534L26.8027 23.6137C26.7603 18.8976 21.1435 16.5251 17.7344 19.685L17.5732 19.8403L8.90332 28.5102C8.51284 28.9007 7.87979 28.9006 7.48926 28.5102C7.12332 28.1441 7.09979 27.565 7.41992 27.1723L7.48926 27.0961L16.1777 18.4077C19.5696 15.0152 17.1791 9.21438 12.3818 9.19672H7.24609C6.69388 9.19672 6.24622 8.7489 6.24609 8.19672C6.24617 7.6445 6.69386 7.19672 7.24609 7.19672H27.8027ZM21.1689 16.2455C23.2741 16.1954 25.3478 17.053 26.8018 18.5776L26.8037 10.6108L21.1689 16.2455ZM17.4424 9.19672C18.9621 10.6475 19.8183 12.7158 19.7695 14.8159L25.3887 9.19672H17.4424Z" fill="white"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="p-4 w-full">
                                        <div class="w-full text-zinc-800">
                                            <h2 class="text-base font-bold leading-5 text-zinc-800">{{ $product->translateAttribute('name') }}</h2>
                                            <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">{{ strip_tags($product->translateAttribute('description')) }}</p>
                                            @if ($product->brand)
                                                <p class="text-xs mt-1">{{ __('Бренд') }}: {{ $product->brand->translateAttribute('name') ?? $product->brand->name ?? 'N/A' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <div class="flex gap-4 justify-between items-end mt-4 px-4 pb-4 w-full">
                                <span class="text-base font-bold leading-tight text-zinc-800">
                                    <x-product-price :product="$product" />
                                </span>
                                    <div>
                                        <livewire:components.add-to-cart :purchasable="$product->variants->first()" :key="'add-to-cart-' . $product->id" />
                                    </div>
                                </div>

                                @if (!$hasValidSlug)
                                    <div class="p-4 text-red-600 text-sm">
                                        Предупреждение: URL или slug отсутствует для продукта ID: {{ $product->id }} (Локаль: {{ app()->getLocale() }})
                                        @dump($product->defaultUrl?->toArray())
                                        @dump($product->slug)
                                    </div>
                                @endif
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

    <!-- Debug Output -->
    <div class="px-4 text-xs text-gray-500">
        Debug: minPrice={{ $minPrice }}, maxPrice={{ $maxPrice }}, priceMax={{ $priceMax }}
    </div>

    <style>
        /* Стили для ползунка цены */
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: #d1d5db;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
        }

        input[type="range"]::-webkit-slider-runnable-track {
            height: 8px;
            background: #d1d5db;
            border-radius: 4px;
        }

        input[type="range"]::-moz-range-track {
            height: 8px;
            background: #d1d5db;
            border-radius: 4px;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #16a34a;
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-top: -4px;
            position: relative;
        }

        input[type="range"]::-webkit-slider-thumb::after {
            content: attr(aria-valuenow) " UAH";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #16a34a;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
        }

        input[type="range"]::-moz-range-thumb {
            width: 12px;
            height: 12px;
            background: #16a34a;
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input[type="range"]:focus {
            outline: none;
        }

        input[type="range"]:focus::-webkit-slider-thumb {
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.3);
        }

        input[type="range"]:focus::-moz-range-thumb {
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.3);
        }

        input[type="number"] {
            border-color: #d1d5db;
            transition: border-color 0.2s ease-in-out;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.3);
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Стили для SVG-иконок в переключателе вида */
        .icon-view {
            stroke: #333333; /* Нейтральный цвет по умолчанию */
        }

        button[aria-pressed="true"] .icon-view {
            stroke: #16a34a; /* Зелёный цвет для активной кнопки */
        }

        button:hover .icon-view {
            stroke: #16a34a; /* Зелёный цвет при наведении */
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', function () {
            console.log('Livewire initialized');
            const priceMaxInput = document.getElementById('price-max');
            const priceMaxDisplay = document.getElementById('price-max-display').querySelector('span');
            const priceMaxNumberInput = document.getElementById('price-max-input');
            const minPrice = parseFloat(priceMaxInput.min) || 0;
            const maxPrice = parseFloat(priceMaxInput.max) || 1000;

            // Проверка, что элементы найдены
            if (!priceMaxInput || !priceMaxDisplay || !priceMaxNumberInput) {
                console.error('Slider elements not found:', {
                    priceMaxInput: !!priceMaxInput,
                    priceMaxDisplay: !!priceMaxDisplay,
                    priceMaxNumberInput: !!priceMaxNumberInput
                });
                return;
            }

            function updatePriceDisplay() {
                let maxVal = parseFloat(priceMaxInput.value);

                // Ограничиваем значение в пределах minPrice и maxPrice
                if (isNaN(maxVal) || maxVal < minPrice) {
                    maxVal = minPrice;
                    priceMaxInput.value = maxVal;
                    Livewire.dispatch('updatePriceMax', { value: maxVal });
                }
                if (maxVal > maxPrice) {
                    maxVal = maxPrice;
                    priceMaxInput.value = maxVal;
                    Livewire.dispatch('updatePriceMax', { value: maxVal });
                }

                // Обновляем отображаемое значение
                priceMaxDisplay.textContent = maxVal.toFixed(2);
                priceMaxNumberInput.value = maxVal.toFixed(2);

                // Обновляем aria-valuenow для доступности
                priceMaxInput.setAttribute('aria-valuenow', maxVal);

                console.log('PriceMax updated:', { maxVal });
            }

            // Обработчик события для ползунка
            priceMaxInput.addEventListener('input', function () {
                console.log('PriceMax Input:', this.value);
                updatePriceDisplay();
            });

            // Обработчик события для поля ввода
            priceMaxNumberInput.addEventListener('input', function () {
                let value = parseFloat(this.value);
                if (isNaN(value) || value < minPrice) {
                    value = minPrice;
                    this.value = minPrice;
                } else if (value > maxPrice) {
                    value = maxPrice;
                    this.value = maxPrice;
                }
                priceMaxInput.value = value;
                console.log('PriceMax Number Input:', value);
                updatePriceDisplay();
            });

            // Инициализация при загрузке
            updatePriceDisplay();

            // Повторная инициализация после обновления Livewire
            document.addEventListener('livewire:navigated', function () {
                console.log('Livewire navigated');
                updatePriceDisplay();
            });
        });
    </script>
</main>
