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

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                                    <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/d7f2f96fb365d97b578a2cfa0ccb76eaba272ebd?placeholderIfAbsent=true"
                                         alt="Placeholder image"
                                         class="object-contain w-full aspect-[1.77]"/>
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
</div>
