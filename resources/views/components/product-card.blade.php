@props(['product'])

@php
    $hasValidSlug = false;
    $slug = null;
    $locale = app()->getLocale();

    // Проверяем slug с учетом локали
    if ($product->defaultUrl && !empty($product->defaultUrl->getTranslation('slug', $locale))) {
        $slug = $product->defaultUrl->getTranslation('slug', $locale);
        $hasValidSlug = is_string($slug) && trim($slug) !== '';
    } elseif (!empty($product->getTranslation('slug', $locale)) && is_string($product->getTranslation('slug', $locale)) && trim($product->getTranslation('slug', $locale)) !== '') {
        $slug = $product->getTranslation('slug', $locale);
        $hasValidSlug = true;
    }

    // Формируем параметры маршрута
    $routeParams = ['slug' => $slug];
    if ($locale !== config('app.fallback_locale')) {
        $routeParams['locale'] = $locale;
    }

    $productUrl = $hasValidSlug ? route('product.view', $routeParams, false) : route('home', $locale !== config('app.fallback_locale') ? ['locale' => $locale] : [], false);
@endphp

<article class="overflow-hidden product-card flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 lg:h-[378px] sm:h-[389px]" role="listitem">
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
            </div>

            <div class="p-4 w-full">
                <div class="w-full text-zinc-800">
                    <h2 class="text-base font-bold leading-5 text-zinc-800">{{ $product->translateAttribute('name') }}</h2>
                    <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">{{ $product->translateAttribute('description') }}</p>
                </div>
            </div>
        </a>

        <div class="flex gap-4 justify-between items-end mt-4 px-4 pb-4 w-full">
            <span class="text-base font-bold leading-tight text-zinc-800">
                <x-product-price :product="$product" />
            </span>

            <livewire:components.add-to-cart :purchasable="$product->variants->first()" :key="'add-to-cart-' . $product->id" />
        </div>

        @if (!$hasValidSlug)
            <div class="p-4 text-red-600 text-sm">
                Предупреждение: URL или slug отсутствует для продукта ID: {{ $product->id }} (Локаль: {{ $locale }})
                @dump($product->defaultUrl?->toArray())
                @dump($product->getTranslations('slug'))
            </div>
        @endif
    </div>
</article>
