<div class="container mx-auto py-8">
    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <nav class="flex flex-wrap gap-2 items-center w-full text-xs font-semibold min-h-[34px] text-neutral-400 max-md:max-w-full" aria-label="Breadcrumb">
        <ol class="flex flex-wrap gap-2 items-center">
            <li class="gap-2 self-stretch py-2 my-auto whitespace-nowrap text-neutral-400">
                <a href="/" class="text-neutral-400 hover:text-neutral-600">{{ __('Головна') }}</a>
            </li>
            <li class="flex gap-2 items-center self-stretch py-2 my-auto whitespace-nowrap text-zinc-800" aria-current="page">
                <span class="self-stretch my-auto w-1.5 text-neutral-400" aria-hidden="true">/</span>
                <span class="self-stretch my-auto text-zinc-800">{{ __('Каталог') }}</span>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold mb-6 mt-4">{{ __('Каталог продуктів') }}</h1>

    <div class="rounded-none max-w-[688px]">
        <!-- Filter Tags and Controls Section -->
        <nav class="flex flex-wrap gap-2 items-center pt-2 w-full max-md:max-w-full" role="navigation" aria-label="Active filters and sorting controls">
            <!-- Active Filter Tags -->
            <div class="flex flex-1 shrink gap-0.5 items-center self-stretch my-auto text-xs font-bold leading-tight text-white basis-8 min-w-60">
                @foreach ($categories as $categoryId)
                    <button wire:click="removeCategory({{ $categoryId }})" class="flex gap-1 items-center pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-neutral-600" aria-label="Remove filter: {{ $collections->firstWhere('id', $categoryId)->translateAttribute('name') }}">
                        <span class="self-stretch my-auto text-white">{{ $collections->firstWhere('id', $categoryId)->translateAttribute('name') }}</span>
                        <span class="self-stretch my-auto w-6 aspect-square">×</span>
                    </button>
                @endforeach
                @foreach ($weights as $weight)
                    <button wire:click="removeWeight('{{ $weight }}')" class="flex gap-1 items-center pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-neutral-600" aria-label="Remove filter: {{ $weight }}">
                        <span class="self-stretch my-auto text-white">{{ $weight }}</span>
                        <span class="self-stretch my-auto w-6 aspect-square">×</span>
                    </button>
                @endforeach
                @if ($priceMin || $priceMax)
                    <button wire:click="clearPrice" class="flex gap-1 items-center pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-neutral-600" aria-label="Remove price filter">
                        <span class="self-stretch my-auto text-white">Ціна: {{ $priceMin ?? '0' }} - {{ $priceMax ?? '∞' }}</span>
                        <span class="self-stretch my-auto w-6 aspect-square">×</span>
                    </button>
                @endif
            </div>

            <!-- Sort Dropdown -->
            <div class="relative">
                <select wire:model="sort" class="flex gap-4 items-center px-4 my-auto text-sm font-bold leading-tight rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 w-[180px] hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-400" aria-label="Sort options">
                    <option value="name_asc">{{ __('Назва А-Я') }}</option>
                    <option value="name_desc">{{ __('Назва Я-А') }}</option>
                    <option value="price_asc">{{ __('Ціна: низька до високої') }}</option>
                    <option value="price_desc">{{ __('Ціна: висока до низької') }}</option>
                </select>
            </div>

            <!-- View Toggle -->
            <div class="flex gap-1 items-center self-stretch p-1 my-auto rounded-2xl bg-neutral-200 min-h-10" role="group" aria-label="View options">
                <button wire:click="setView('grid')" class="flex gap-2.5 items-center p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-400" aria-label="Grid view">
                    <div class="flex self-stretch my-auto w-6 min-h-6 bg-gray-400 rounded {{ $view == 'grid' ? 'bg-green-600' : '' }}"></div>
                </button>
                <button wire:click="setView('list')" class="flex gap-2.5 items-center p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-400" aria-label="List view">
                    <div class="flex self-stretch my-auto w-6 min-h-6 bg-gray-400 rounded {{ $view == 'list' ? 'bg-green-600' : '' }}"></div>
                </button>
            </div>
        </nav>

        <!-- Filters Panel -->
        <aside class="w-56 max-w-full rounded-3xl bg-neutral-200 mt-4" aria-label="Product filters">
            <!-- Product Type Filter -->
            <section class="w-full rounded-2xl text-zinc-800">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight rounded-2xl bg-neutral-200 min-h-10 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-400" aria-expanded="true" aria-controls="product-type-options">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Тип товару') }}</span>
                    <div class="dropdown-arrow"></div>
                </button>
                <div id="product-type-options" class="flex items-start pr-0.5 pb-2 w-full text-xs font-semibold whitespace-nowrap rounded-2xl bg-neutral-200">
                    <div class="flex-1 shrink w-full basis-0">
                        @foreach ($collections as $collection)
                            <label class="flex gap-2 items-center px-4 py-2 w-full min-h-10 cursor-pointer hover:bg-neutral-300">
                                <div class="flex shrink-0 self-stretch my-auto w-6 h-6 rounded border-solid border-[1.5px] border-neutral-400 {{ in_array($collection->id, $categories) ? 'bg-green-600' : 'bg-white' }}"></div>
                                <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ $collection->translateAttribute('name') }}</span>
                                <input type="checkbox" wire:model="categories" value="{{ $collection->id }}" class="sr-only" />
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Divider -->
            <div class="px-4 w-full">
                <hr class="w-full rounded-sm bg-zinc-300 border-0 h-px" />
            </div>

            <!-- Price Filter -->
            <section class="py-4 w-full rounded-2xl bg-neutral-200">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight whitespace-nowrap rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-400" aria-expanded="true" aria-controls="price-options">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Ціна') }}</span>
                    <div class="dropdown-arrow"></div>
                </button>
                <div id="price-options" class="w-full">
                    <div class="flex gap-2 justify-center items-center px-4 w-full text-xs font-semibold text-zinc-800">
                        <input type="number" wire:model="priceMin" class="bg-transparent text-zinc-800 border-none outline-none text-center" placeholder="{{ $minPrice ?? '0' }}" aria-label="Minimum price" />
                        <span class="self-stretch my-auto text-zinc-800">-</span>
                        <input type="number" wire:model="priceMax" class="bg-transparent text-zinc-800 border-none outline-none text-center" placeholder="{{ $maxPrice ?? '∞' }}" aria-label="Maximum price" />
                    </div>
                </div>
            </section>

            <!-- Divider -->
            <div class="px-4 w-full">
                <hr class="w-full rounded-sm bg-zinc-300 border-0 h-px" />
            </div>

            <!-- Weight Filter -->
            <section class="w-full rounded-2xl">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight whitespace-nowrap rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-neutral-400" aria-expanded="true" aria-controls="weight-options">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Вага') }}</span>
                    <div class="dropdown-arrow"></div>
                </button>
                <div id="weight-options" class="flex pr-0.5 pb-2 w-full rounded-2xl bg-neutral-200">
                    <div class="flex-1 shrink self-start w-full text-xs font-semibold basis-0 text-zinc-800 max-h-64 overflow-y-auto scrollbar-thin">
                        @foreach ($availableWeights as $weight)
                            <label class="flex gap-2 items-center px-4 py-2 w-full min-h-10 cursor-pointer hover:bg-neutral-300">
                                <div class="flex shrink-0 self-stretch my-auto w-6 h-6 rounded border-solid border-[1.5px] border-neutral-400 {{ in_array($weight, $weights) ? 'bg-green-600' : 'bg-white' }}"></div>
                                <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ $weight }}</span>
                                <input type="checkbox" wire:model="weights" value="{{ $weight }}" class="sr-only" />
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Apply Button -->
            <div class="flex gap-2 items-start p-4 w-full text-base font-bold leading-snug text-green-600 whitespace-nowrap">
                <button wire:click="applyFilters" class="flex flex-1 shrink gap-2 justify-center items-center px-6 py-2.5 w-full rounded-2xl border-2 border-green-600 border-solid basis-0 min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-700">
                    <span class="self-stretch my-auto text-green-600">{{ __('Застосувати') }}</span>
                </button>
            </div>
        </aside>
    </div>

    <div class="{{ $view == 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6' : 'flex flex-col gap-6' }} mt-6">
        @foreach ($products as $product)
            <article class="overflow-hidden flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 min-w-60" role="listitem">
                <div class="block group">
                    <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate class="block">
                        <div class="flex relative flex-col w-full min-h-[153px]">
                            <div class="flex overflow-hidden absolute top-1/2 left-1/2 z-0 flex-col px-1.5 max-w-full -translate-x-1/2 -translate-y-1/2 h-[163px] w-[300px]">
                                @if ($product->thumbnail)
                                    <img src="{{ $product->thumbnail->getUrl('medium') }}"
                                         alt="{{ $product->translateAttribute('name') }}"
                                         class="object-contain w-full aspect-[1.77] transition-transform duration-300 group-hover:scale-105"/>
                                @else
                                    <img src="https://via.placeholder.com/300x169" alt="Placeholder image" class="object-contain w-full aspect-[1.77]"/>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 w-full">
                            <div class="w-full text-zinc-800">
                                <h2 class="text-base font-bold leading-5 text-zinc-800">{{ $product->translateAttribute('name') }}</h2>
                                <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">{{ strip_tags($product->translateAttribute('description')) }}</p>
                            </div>
                        </div>
                    </a>

                    <div class="flex gap-4 justify-between items-center mt-4 px-4 pb-4 w-full">
                        <span class="text-base font-bold leading-tight text-zinc-800">
                            <x-product-price :product="$product" />
                        </span>

                        <livewire:components.add-to-cart :purchasable="$product->variants->first()" />
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

        <style>
            .dropdown-arrow::after {
                content: '';
                display: inline-block;
                width: 0;
                height: 0;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
                border-top: 5px solid #3f3f46;
                margin-left: 8px;
            }
        </style>
</div>
