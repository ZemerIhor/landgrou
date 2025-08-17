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

            // Устанавливаем новую локаль
            $languageService->setLocale($locale);
            $this->currentLocale = $locale;

            // Получаем новый URL
            $newUrl = $this->getNewUrl($locale);

            \Log::info('Livewire language switch', [
                'locale' => $locale,
                'new_url' => $newUrl,
                'current_path' => request()->path(),
            ]);

            // Отправляем событие для обновления URL и перезагрузки компонентов
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

        // Для страниц продуктов
        if (preg_match('#^products/([^/]+)$#', $currentPath, $matches)) {
            return $this->getProductUrl($matches[1], $locale);
        }

        // Для обычных страниц
        return $this->getRegularPageUrl($currentPath, $locale);
    }

    private function getProductUrl(string $currentSlug, string $locale): string
    {
        try {
            $urlRecord = LunarUrl::where('slug', $currentSlug)
                ->where('element_type', Product::class)
                ->first();

            if (!$urlRecord) {
                return "/products/{$currentSlug}";
            }

            $product = $urlRecord->element;
            $language = Language::where('code', $locale)->first();

            if (!$language) {
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
        // Убираем текущую локаль из пути
        $segments = explode('/', ltrim($currentPath, '/'));
        if (in_array($segments[0] ?? '', $this->availableLocales)) {
            array_shift($segments);
        }

        $pathWithoutLocale = implode('/', $segments);

        // Добавляем новую локаль
        if ($locale === config('app.locale', 'en')) {
            return "/{$pathWithoutLocale}";
        }

        return "/{$locale}/{$pathWithoutLocale}";
    }

    private function needsReload(): bool
    {
        // Определяем, нужна ли полная перезагрузка страницы
        // Для продуктов - да, для других страниц можно попробовать без перезагрузки
        return request()->is('products/*');
    }

    public function render()
    {
        return view('livewire.components.language-switcher');
    }
}
