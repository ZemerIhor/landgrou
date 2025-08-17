<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Services\LanguageService;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Language;
use Lunar\Models\Product;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public $currentLocale;
    public $availableLocales = ['en', 'uk'];
    public $originalPath;

    public function mount()
    {
        $this->currentLocale = app()->getLocale();
        // Получаем исходный путь из сессии или текущего запроса
        $this->originalPath = Session::get('original_path', request()->path());
        // Если текущий путь не livewire/update, обновляем сессию
        if (!str_contains($this->originalPath, 'livewire/update')) {
            Session::put('original_path', request()->path());
            $this->originalPath = request()->path();
        }
        \Log::debug('LanguageSwitcher mounted', [
            'currentLocale' => $this->currentLocale,
            'originalPath' => $this->originalPath,
            'currentPath' => request()->path(),
        ]);
    }

    public function switchLanguage($locale)
    {
        if (!in_array($locale, $this->availableLocales)) {
            \Log::error('Invalid locale attempted', ['locale' => $locale]);
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
            $needsReload = $this->needsReload();

            \Log::info('Livewire language switch', [
                'locale' => $locale,
                'new_url' => $newUrl,
                'original_path' => $this->originalPath,
                'current_path' => request()->path(),
                'needs_reload' => $needsReload,
            ]);

            // Отправляем событие для обновления URL
            $this->dispatch('language-switched', [
                'locale' => $locale,
                'url' => $newUrl,
                'reload' => $needsReload,
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
        $currentPath = $this->originalPath;
        \Log::debug('Current path in getNewUrl', ['path' => $currentPath]);

        // Если путь livewire/update, используем fallback
        if (str_contains($currentPath, 'livewire/update')) {
            \Log::warning('Livewire update path detected, using fallback', ['originalPath' => $currentPath]);
            $currentPath = Session::get('last_valid_path', '/'); // Fallback на главную страницу
        }

        // Для продуктовых страниц
        if (preg_match('#^(?:[a-z]{2}/)?products/([^/]+)$#', $currentPath, $matches)) {
            $slug = $matches[1];
            \Log::debug('Detected product page', ['slug' => $slug]);
            return $this->getProductUrl($slug, $locale);
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
                \Log::warning('No URL record found for slug', ['slug' => $currentSlug, 'locale' => $locale]);
                return "/products/{$currentSlug}";
            }

            $product = $urlRecord->element;
            $language = Language::where('code', $locale)->first();

            if (!$language) {
                \Log::warning('No language found for locale', ['locale' => $locale]);
                return "/products/{$currentSlug}";
            }

            $localizedUrlRecord = $product->urls()
                ->where('language_id', $language->id)
                ->first();

            if (!$localizedUrlRecord) {
                \Log::warning('No localized URL record found, falling back to default', [
                    'product_id' => $product->id,
                    'locale' => $locale,
                ]);
                $localizedUrlRecord = $product->urls()
                    ->where('default', true)
                    ->first();
            }

            $newSlug = $localizedUrlRecord ? $localizedUrlRecord->slug : $currentSlug;
            \Log::info('Product URL resolved', [
                'currentSlug' => $currentSlug,
                'locale' => $locale,
                'product_id' => $product ? $product->id : null,
                'newSlug' => $newSlug,
                'urlRecord' => $urlRecord ? $urlRecord->toArray() : null,
                'localizedUrlRecord' => $localizedUrlRecord ? $localizedUrlRecord->toArray() : null,
            ]);

            return "/products/{$newSlug}";

        } catch (\Exception $e) {
            \Log::error('Error getting product URL', [
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
        $pathWithoutLocale = $pathWithoutLocale ?: ''; // Обрабатываем корневой путь

        \Log::debug('Regular page URL resolved', [
            'currentPath' => $currentPath,
            'locale' => $locale,
            'pathWithoutLocale' => $pathWithoutLocale,
        ]);

        // Для fallback-локали (en) не добавляем префикс
        if ($locale === config('app.fallback_locale', 'en')) {
            $newUrl = "/{$pathWithoutLocale}";
            return $newUrl === '//' ? '/' : $newUrl; // Обрабатываем случай, когда pathWithoutLocale пустой
        }

        // Для других локалей добавляем префикс
        $newUrl = "/{$locale}/{$pathWithoutLocale}";
        return $newUrl === "/{$locale}/" ? "/{$locale}" : $newUrl; // Убираем лишний слеш в конце
    }

    private function needsReload(): bool
    {
        $isProductPage = preg_match('#^(?:[a-z]{2}/)?products/([^/]+)$#', $this->originalPath);
        \Log::debug('Checking if reload is needed', [
            'path' => $this->originalPath,
            'isProductPage' => $isProductPage,
        ]);
        return $isProductPage;
    }

    public function render()
    {
        return view('livewire.components.language-switcher');
    }
}
