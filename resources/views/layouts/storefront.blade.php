<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $settings = app(\App\Settings\GlobalSettings::class);
        $locale = app()->getLocale();
        $currentRoute = request()->route() ? request()->route()->getName() : 'home';

        // По умолчанию используем site_name и meta_description
        $pageTitle = $settings->site_name[$locale] ?? 'Назва сайту';
        $pageDescription = $settings->meta_description[$locale] ?? 'Опис сайту за замовчуванням';

        // Определяем заголовок и мета-описание в зависимости от маршрута
        switch ($currentRoute) {
            // Статические страницы
            case 'home':
                $pageTitle = $settings->home_title[$locale] ?? 'Головна';
                $pageDescription = $settings->home_meta_description[$locale] ?? 'Опис головної сторінки';
                break;
            case 'about-us':
                $pageTitle = $settings->about_us_title[$locale] ?? 'Про нас';
                $pageDescription = $settings->about_us_meta_description[$locale] ?? 'Опис сторінки "Про нас"';
                break;
            case 'contacts':
                $pageTitle = $settings->contacts_title[$locale] ?? 'Контакти';
                $pageDescription = $settings->contacts_meta_description[$locale] ?? 'Опис сторінки контактів';
                break;
            case 'faq':
                $pageTitle = $settings->faq_title[$locale] ?? 'Часті запитання';
                $pageDescription = $settings->faq_meta_description[$locale] ?? 'Опис сторінки частих запитань';
                break;
            case 'reviews':
                $pageTitle = $settings->reviews_title[$locale] ?? 'Відгуки';
                $pageDescription = $settings->reviews_meta_description[$locale] ?? 'Опис сторінки відгуків';
                break;
            case 'submit-review':
                $pageTitle = $settings->submit_review_title[$locale] ?? 'Залишити відгук';
                $pageDescription = $settings->submit_review_meta_description[$locale] ?? 'Опис сторінки залишення відгуку';
                break;
            case 'blog.index':
                $pageTitle = $settings->blog_title[$locale] ?? 'Блог';
                $pageDescription = $settings->blog_meta_description[$locale] ?? 'Опис сторінки блогу';
                break;
            case 'checkout.view':
                $pageTitle = $settings->checkout_title[$locale] ?? 'Оформлення замовлення';
                $pageDescription = $settings->checkout_meta_description[$locale] ?? 'Опис сторінки оформлення замовлення';
                break;
            case 'checkout-success.view':
                $pageTitle = $settings->checkout_success_title[$locale] ?? 'Замовлення успішно оформлено';
                $pageDescription = $settings->checkout_success_meta_description[$locale] ?? 'Опис сторінки успішного замовлення';
                break;

            // Продуктовые и системные страницы
            case 'catalog.view':
                $pageTitle = 'Каталог';
                $pageDescription = 'Опис сторінки каталогу';
                break;
            case 'product.view':
                $language = \Lunar\Models\Language::where('code', $locale)->first();
                $url = \Lunar\Models\Url::where('slug', request()->route()->parameter('slug'))
                    ->where('element_type', 'Lunar\Models\Product')
                    ->where('language_id', $language ? $language->id : 1)
                    ->first();

                if (!$url) {
                    $url = \Lunar\Models\Url::where('slug', request()->route()->parameter('slug'))
                        ->where('element_type', 'Lunar\Models\Product')
                        ->where('default', 1)
                        ->first();
                }

                $product = $url ? \Lunar\Models\Product::where('id', $url->element_id)
                    ->where('status', 'published')
                    ->first() : null;

                \Illuminate\Support\Facades\Log::info('Product View Meta', [
                    'locale' => $locale,
                    'slug' => request()->route()->parameter('slug'),
                    'url_found' => $url ? $url->toArray() : null,
                    'product_found' => $product ? $product->id : null,
                    'product_name' => $product ? $product->getTranslation('name', $locale) : null,
                    'product_description' => $product ? $product->getTranslation('description', $locale) : null,
                ]);

                $pageTitle = $product && $product->getTranslation('name', $locale)
                    ? $product->getTranslation('name', $locale)
                    : 'Продукт';
                $pageDescription = $product && $product->getTranslation('description', $locale)
                    ? strip_tags($product->getTranslation('description', $locale))
                    : 'Опис продукту за замовчуванням';
                break;
            case 'collection.view':
                $language = \Lunar\Models\Language::where('code', $locale)->first();
                $url = \Lunar\Models\Url::where('slug', request()->route()->parameter('slug'))
                    ->where('element_type', 'Lunar\Models\Collection')
                    ->where('language_id', $language ? $language->id : 1)
                    ->first();
                if (!$url) {
                    $url = \Lunar\Models\Url::where('slug', request()->route()->parameter('slug'))
                        ->where('element_type', 'Lunar\Models\Collection')
                        ->where('default', 1)
                        ->first();
                }
                $collection = $url ? \Lunar\Models\Collection::where('id', $url->element_id)->first() : null;
                $pageTitle = $collection ? ($collection->getTranslation('name', $locale) ?? 'Колекція') : 'Колекція';
                $pageDescription = $collection ? (strip_tags($collection->getTranslation('description', $locale)) ?? 'Опис колекції') : 'Опис колекції';
                break;
            case 'search.view':
            case 'products.index':
                $pageTitle = 'Пошук';
                $pageDescription = 'Опис сторінки пошуку';
                break;
            case 'blog.post':
                $post = \App\Models\BlogPost::where('slug', request()->route()->parameter('slug'))->first();
                $pageTitle = $post ? ($post->getTranslation('title', $locale) ?? 'Стаття блогу') : 'Стаття блогу';
                $pageDescription = $post ? (strip_tags($post->getTranslation('excerpt', $locale)) ?? 'Опис статті блогу') : 'Опис статті блогу';
                break;
            case 'privacy-policy':
                $pageTitle = 'Політика конфіденційності';
                $pageDescription = 'Опис сторінки політики конфіденційності';
                break;
            case 'terms':
                $pageTitle = 'Умови використання';
                $pageDescription = 'Опис сторінки умов використання';
                break;
        }
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    @if ($settings->favicon)
        <link rel="icon" href="{{ Storage::url($settings->favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.svg') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex flex-col min-h-screen antialiased text-gray-900 relative">
@livewire('components.navigation')

<div class="">
    {{ $slot }}
</div>

@livewireScripts
@stack('scripts')

<x-footer/>
<button
    id="scrollToTopBtn"
    type="button"
    aria-label="Прокрутити до початку сторінки"
    class="flex fixed bottom-4 right-4 z-50 gap-2.5 justify-center items-center self-start px-3 w-12 h-12 bg-green-600 rounded-[32px] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-zinc-800 transition-colors duration-200"
>
    <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg" class="text-white">
            <path d="M7 14L12 9L17 14" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</button>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.remove('hidden');
                scrollBtn.classList.add('flex');
            } else {
                scrollBtn.classList.remove('flex');
                scrollBtn.classList.add('hidden');
            }
        });
    });
</script>
</body>
</html>
