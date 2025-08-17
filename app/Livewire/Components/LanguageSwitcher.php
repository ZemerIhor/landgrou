<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Services\LanguageService;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Language;
use Lunar\Models\Product;

class LanguageSwitcher extends Component
{
    public $currentLocale;
    public $availableLocales = ['en', 'uk'];

    public function mount()
    {
        $this->currentLocale = app()->getLocale();
    }

    public function switchLanguage($locale)
    {
        if (!in_array($locale, $this->availableLocales)) {
            $this->dispatch('language-error', 'Invalid locale');
            return;
        }

        try {
            $languageService = app(LanguageService::class);

            // Set new locale
            $languageService->setLocale($locale);
            $this->currentLocale = $locale;

            // Get new URL
            $newUrl = $this->getNewUrl($locale);

            \Log::info('Livewire language switch', [
                'locale' => $locale,
                'new_url' => $newUrl,
                'current_path' => request()->path(),
            ]);

            // Dispatch event for URL update
            $this->dispatch('language-switched', [
                'locale' => $locale,
                'url' => $newUrl,
                'reload' => $this->needsReload()
            ]);

        } catch (\Exception $e) {
            \Log::error('Livewire language switch error', [
                'locale' => $locale,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('language-error', 'Language switch failed');
        }
    }

    private function getNewUrl($locale): string
    {
        $currentPath = request()->path();

        // For product pages
        if (preg_match('#^products/([^/]+)$#', $currentPath, $matches)) {
            return $this->getProductUrl($matches[1], $locale);
        }

        // For regular pages
        return $this->getRegularPageUrl($currentPath, $locale);
    }

    private function getProductUrl(string $currentSlug, string $locale): string
    {
        try {
            $urlRecord = LunarUrl::where('slug', $currentSlug)
                ->where('element_type', Product::class)
                ->first();

            if (!$urlRecord) {
                \Log::warning('No URL record found', ['slug' => $currentSlug, 'locale' => $locale]);
                return "/products/{$currentSlug}";
            }

            $product = $urlRecord->element;
            $language = Language::where('code', $locale)->first();

            if (!$language) {
                \Log::warning('No language found', ['locale' => $locale]);
                return "/products/{$currentSlug}";
            }

            $localizedUrlRecord = $product->urls()
                ->where('language_id', $language->id)
                ->first();

            if (!$localizedUrlRecord) {
                $localizedUrlRecord = $product->urls()
                    ->where('default', true)
                    ->first();
            }

            $newSlug = $localizedUrlRecord ? $localizedUrlRecord->slug : $currentSlug;
            \Log::info('Product URL Debug', [
                'currentSlug' => $currentSlug,
                'locale' => $locale,
                'urlRecord' => $urlRecord ? $urlRecord->toArray() : null,
                'product' => $product ? $product->toArray() : null,
                'localizedUrlRecord' => $localizedUrlRecord ? $localizedUrlRecord->toArray() : null,
                'newSlug' => $newSlug,
            ]);
            return "/products/{$newSlug}";

        } catch (\Exception $e) {
            \Log::error('Error getting product URL in Livewire', [
                'slug' => $currentSlug,
                'locale' => $locale,
                'error' => $e->getMessage(),
            ]);
            return "/products/{$currentSlug}";
        }
    }

    private function getRegularPageUrl(string $currentPath, string $locale): string
    {
        // Remove current locale from path
        $segments = explode('/', ltrim($currentPath, '/'));
        if (in_array($segments[0] ?? '', $this->availableLocales)) {
            array_shift($segments);
        }

        $pathWithoutLocale = implode('/', $segments);

        // Add new locale
        if ($locale === config('app.locale', 'en')) {
            return "/{$pathWithoutLocale}";
        }

        return "/{$locale}/{$pathWithoutLocale}";
    }

    private function needsReload(): bool
    {
        // Full reload for product pages
        return request()->is('products/*');
    }

    public function render()
    {
        return view('livewire.components.language-switcher');
    }
}
