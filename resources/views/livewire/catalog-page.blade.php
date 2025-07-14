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
                    <span class="self-stretch my-auto text-white">{{ __('Цена') }}: {{ number_format($priceMin ?? 0, 2) }}-{{ number_format($priceMax ?? $maxPrice, 2) }} UAH</span>
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

            <!-- Price Filter (Range Sliders) -->
            <section class="py-4 w-full rounded-2xl bg-neutral-200">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight whitespace-nowrap rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-expanded="true" aria-controls="price-filter">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Цена') }}</span>
                    <div class="flex shrink-0 self-stretch my-auto w-4 h-4 rotate-[-3.1415925661670165rad]" aria-hidden="true"></div>
                </button>
                <div id="price-filter" class="flex flex-col gap-4 items-start mx-auto my-0 w-[280px] max-md:w-full max-md:max-w-[280px]">
                    <!-- Price Range Display -->
                    <div class="flex justify-between w-full px-4">
                        <span class="text-xs font-bold leading-5 text-zinc-800" id="price-min-display">
                            {{ __('Мин. цена') }}: <span>{{ number_format($priceMin ?? $minPrice, 2) }}</span> UAH
                        </span>
                        <span class="text-xs font-bold leading-5 text-zinc-800" id="price-max-display">
                            {{ __('Макс. цена') }}: <span>{{ number_format($priceMax ?? $maxPrice, 2) }}</span> UAH
                        </span>
                    </div>
                    <!-- Range Sliders -->
                    <div class="relative w-full px-4 range-slider-container">
                        <div class="relative h-2 bg-neutral-400 rounded-full">
                            <div class="absolute h-2 bg-green-600 rounded-full range-fill" id="range-fill"></div>
                            <input type="range"
                                   wire:model.debounce.500ms="priceMin"
                                   id="price-min"
                                   min="{{ $minPrice }}"
                                   max="{{ $maxPrice }}"
                                   step="{{ ($maxPrice - $minPrice) > 10000 ? 10 : 1 }}"
                                   value="{{ $priceMin ?? $minPrice }}"
                                   class="absolute w-full h-2 cursor-pointer z-10"
                                   aria-label="Минимальная цена"
                                   aria-valuemin="{{ $minPrice }}"
                                   aria-valuemax="{{ $maxPrice }}"
                                   aria-valuenow="{{ $priceMin ?? $minPrice }}" />
                            <input type="range"
                                   wire:model.debounce.500ms="priceMax"
                                   id="price-max"
                                   min="{{ $minPrice }}"
                                   max="{{ $maxPrice }}"
                                   step="{{ ($maxPrice - $minPrice) > 10000 ? 10 : 1 }}"
                                   value="{{ $priceMax ?? $maxPrice }}"
                                   class="absolute w-full h-2 cursor-pointer z-10"
                                   aria-label="Максимальная цена"
                                   aria-valuemin="{{ $minPrice }}"
                                   aria-valuemax="{{ $maxPrice }}"
                                   aria-valuenow="{{ $priceMax ?? $maxPrice }}" />
                        </div>
                    </div>
                    <!-- Manual Input Fields -->
                    <div class="flex justify-between w-full px-4 gap-2">
                        <input type="number"
                               wire:model.debounce.500ms="priceMin"
                               id="price-min-input"
                               class="w-20 px-2 py-1 border rounded text-xs"
                               placeholder="{{ $minPrice }}"
                               aria-label="Ввести минимальную цену"
                               min="{{ $minPrice }}"
                               max="{{ $maxPrice }}"
                               step="{{ ($maxPrice - $minPrice) > 10000 ? 10 : 1 }}" />
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

    <!-- Debug Output -->
    <div class="px-4 text-xs text-gray-500">
        Debug: minPrice={{ $minPrice }}, maxPrice={{ $maxPrice }}, priceMin={{ $priceMin }}, priceMax={{ $priceMax }}
    </div>

    <style>
        /* Стили для ползунков диапазона цен */
        .range-slider-container {
            position: relative;
            height: 8px;
            background: #d1d5db;
            border-radius: 4px;
            margin-top: 10px;
        }

        .range-fill {
            position: absolute;
            height: 100%;
            background: #16a34a;
            border-radius: 4px;
            z-index: 1;
        }

        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: transparent;
            position: absolute;
            top: 0;
            margin: 0;
            cursor: pointer;
            z-index: 2;
        }

        input[type="range"]::-webkit-slider-runnable-track {
            height: 8px;
            background: transparent;
        }

        input[type="range"]::-moz-range-track {
            height: 8px;
            background: transparent;
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
    </style>

    <script>
        document.addEventListener('livewire:initialized', function () {
            console.log('Livewire initialized');
            const priceMinInput = document.getElementById('price-min');
            const priceMaxInput = document.getElementById('price-max');
            const priceMinDisplay = document.getElementById('price-min-display').querySelector('span');
            const priceMaxDisplay = document.getElementById('price-max-display').querySelector('span');
            const priceMinNumberInput = document.getElementById('price-min-input');
            const priceMaxNumberInput = document.getElementById('price-max-input');
            const rangeFill = document.getElementById('range-fill');
            const minPrice = parseFloat(priceMinInput.min) || 0;
            const maxPrice = parseFloat(priceMaxInput.max) || 1000;

            // Проверка, что элементы найдены
            if (!priceMinInput || !priceMaxInput || !priceMinDisplay || !priceMaxDisplay || !rangeFill || !priceMinNumberInput || !priceMaxNumberInput) {
                console.error('Slider elements not found:', {
                    priceMinInput: !!priceMinInput,
                    priceMaxInput: !!priceMaxInput,
                    priceMinDisplay: !!priceMinDisplay,
                    priceMaxDisplay: !!priceMaxDisplay,
                    rangeFill: !!rangeFill,
                    priceMinNumberInput: !!priceMinNumberInput,
                    priceMaxNumberInput: !!priceMaxNumberInput
                });
                return;
            }

            function updateRangeFill() {
                let minVal = parseFloat(priceMinInput.value);
                let maxVal = parseFloat(priceMaxInput.value);

                // Ограничиваем минимальную цену, чтобы не превышала максимальную
                if (minVal > maxVal) {
                    minVal = maxVal;
                    priceMinInput.value = minVal;
                    Livewire.dispatch('updatePriceMin', { value: minVal });
                }

                // Ограничиваем максимальную цену, чтобы не была меньше минимальной
                if (maxVal < minVal) {
                    maxVal = minVal;
                    priceMaxInput.value = maxVal;
                    Livewire.dispatch('updatePriceMax', { value: maxVal });
                }

                // Ограничиваем значения в пределах minPrice и maxPrice
                if (minVal < minPrice || isNaN(minVal)) {
                    minVal = minPrice;
                    priceMinInput.value = minVal;
                    Livewire.dispatch('updatePriceMin', { value: minVal });
                }
                if (maxVal > maxPrice || isNaN(maxVal)) {
                    maxVal = maxPrice;
                    priceMaxInput.value = maxVal;
                    Livewire.dispatch('updatePriceMax', { value: maxVal });
                }

                // Обновляем полосу заполнения
                const minPercent = ((minVal - minPrice) / (maxPrice - minPrice)) * 100;
                const maxPercent = ((maxVal - minPrice) / (maxPrice - minPrice)) * 100;
                rangeFill.style.left = minPercent + '%';
                rangeFill.style.width = (maxPercent - minPercent) + '%';

                // Обновляем отображаемые значения
                priceMinDisplay.textContent = minVal.toFixed(2);
                priceMaxDisplay.textContent = maxVal.toFixed(2);
                priceMinNumberInput.value = minVal.toFixed(2);
                priceMaxNumberInput.value = maxVal.toFixed(2);

                // Обновляем aria-valuenow для доступности
                priceMinInput.setAttribute('aria-valuenow', minVal);
                priceMaxInput.setAttribute('aria-valuenow', maxVal);

                console.log('Range updated:', { minVal, maxVal, minPercent, maxPercent });
            }

            // Обработчики событий для ползунков
            priceMinInput.addEventListener('input', function () {
                console.log('PriceMin Input:', this.value);
                updateRangeFill();
            });

            priceMaxInput.addEventListener('input', function () {
                console.log('PriceMax Input:', this.value);
                updateRangeFill();
            });

            // Обработчики событий для полей ввода
            priceMinNumberInput.addEventListener('input', function () {
                let value = parseFloat(this.value);
                if (isNaN(value) || value < minPrice) {
                    value = minPrice;
                    this.value = minPrice;
                } else if (value > maxPrice) {
                    value = maxPrice;
                    this.value = maxPrice;
                }
                priceMinInput.value = value;
                console.log('PriceMin Number Input:', value);
                updateRangeFill();
            });

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
                updateRangeFill();
            });

            // Инициализация при загрузке
            updateRangeFill();

            // Повторная инициализация после обновления Livewire
            document.addEventListener('livewire:navigated', function () {
                console.log('Livewire navigated');
                updateRangeFill();
            });
        });
    </script>
</main>
