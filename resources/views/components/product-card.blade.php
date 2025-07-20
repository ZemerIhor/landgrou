@props(['product'])

@php
    $hasValidSlug = false;
    $slug = null;
    $locale = app()->getLocale();

    // Используем геттер slug из модели App\Models\Product
    $slug = $product->slug;
    $hasValidSlug = is_string($slug) && trim($slug) !== '';

    // Формируем параметры маршрута
    $routeParams = ['slug' => $slug];
    if ($locale !== config('app.fallback_locale')) {
        $routeParams['locale'] = $locale;
    }

    $productUrl = $hasValidSlug ? route('product.view', $routeParams, false) : route('home', $locale !== config('app.fallback_locale') ? ['locale' => $locale] : [], false);

    // Извлекаем name и description из attribute_data
    $name = $product->attribute_data['name'] ?? null;
    $description = $product->attribute_data['description'] ?? null;
    $nameValue = ($name instanceof \Lunar\FieldTypes\TranslatedText) ? ($name->value[$locale] ?? $name->value[config('app.fallback_locale')] ?? 'Product') : 'Product';
    $descriptionValue = ($description instanceof \Lunar\FieldTypes\TranslatedText) ? ($description->value[$locale] ?? $description->value[config('app.fallback_locale')] ?? '') : '';
dd($product)
    @endphp

<article class="overflow-hidden product-card flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200" role="listitem">
    <div class="flex flex-col justify-between group h-full">
        <a href="{{ $productUrl }}" wire:navigate class="flex flex-col h-full">
            <div class="flex relative flex-col w-full">
                <div class="flex overflow-hidden flex-col max-w-full w-full">
                    @if ($product->thumbnail)
                        <img src="{{ $product->thumbnail->getUrl() }}"
                             alt="{{ $nameValue }}"
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
                    <h2 class="text-base font-bold leading-5 text-zinc-800">{{ $nameValue }}</h2>
                    <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">{{ $descriptionValue }}</p>
                </div>
            </div>
        </a>

        <div class="flex gap-4 justify-between items-end mt-4 px-4 pb-4 w-full">
            <span class="text-base font-bold leading-tight text-zinc-800">
                <x-product-price :product="$product" />
            </span>

            <livewire:components.add-to-cart :purchasable="$product->variants->first()" :key="'add-to-cart-' . $product->id" />
        </div>

    </div>
</article>
