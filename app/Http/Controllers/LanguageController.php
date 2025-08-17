<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL as FacadeURL;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Language;
use Lunar\Models\Product;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(string $locale, Request $request)
    {
        // Валидация локали
        if (!in_array($locale, ['uk', 'en'])) {
            return Redirect::back()->with('error', 'Invalid locale');
        }

        $languageService = app(LanguageService::class);

        try {
            // Получаем URL для редиректа
            $redirectTo = $request->get('redirect_to', $request->header('referer', '/'));

            \Log::info('Language switch started', [
                'locale' => $locale,
                'redirect_to' => $redirectTo,
                'current_locale' => app()->getLocale(),
            ]);

            // Устанавливаем локаль в сессии
            session(['locale' => $locale]);
            app()->setLocale($locale);

            // Определяем новый URL
            $newUrl = $this->getLocalizedUrl($redirectTo, $locale);

            \Log::info('Language switch completed', [
                'locale' => $locale,
                'original_url' => $redirectTo,
                'new_url' => $newUrl,
            ]);

            return redirect($newUrl);
        } catch (\Exception $e) {
            \Log::error('Language switch error', [
                'locale' => $locale,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Redirect::back()->with('error', 'Language switch failed');
        }
    }

    /**
     * Получить локализованный URL
     */
    private function getLocalizedUrl(string $originalUrl, string $locale): string
    {
        // Парсим URL
        $parsedUrl = parse_url($originalUrl);
        $path = $parsedUrl['path'] ?? '/';
        $query = $parsedUrl['query'] ?? '';

        // Убираем домен и получаем только путь
        $path = ltrim($path, '/');

        // Удаляем текущую локаль из пути, если она есть
        $segments = explode('/', $path);
        if (in_array($segments[0] ?? '', ['en', 'uk'])) {
            array_shift($segments);
        }

        $pathWithoutLocale = implode('/', $segments);

        \Log::info('URL parsing', [
            'original_url' => $originalUrl,
            'path' => $path,
            'path_without_locale' => $pathWithoutLocale,
            'segments' => $segments,
        ]);

        // Проверяем, является ли это страницей продукта
        if (preg_match('#^products/([^/]+)/?$#', $pathWithoutLocale, $matches)) {
            return $this->getProductUrl($matches[1], $locale, $query);
        }

        // Для остальных страниц добавляем префикс локали
        $newPath = $locale === config('app.locale', 'en')
            ? "/{$pathWithoutLocale}"
            : "/{$locale}/{$pathWithoutLocale}";

        // Убираем двойные слэши
        $newPath = preg_replace('#/+#', '/', $newPath);

        // Добавляем query параметры, если они есть
        return $query ? "{$newPath}?{$query}" : $newPath;
    }

    /**
     * Получить URL продукта для указанной локали
     */
    private function getProductUrl(string $currentSlug, string $locale, string $query = ''): string
    {
        try {
            // Ищем текущий URL записи продукта
            $urlRecord = LunarUrl::where('slug', $currentSlug)
                ->where('element_type', Product::class)
                ->first();

            if (!$urlRecord) {
                \Log::warning('Product URL record not found', ['slug' => $currentSlug]);
                return $this->fallbackProductUrl($currentSlug, $locale, $query);
            }

            $product = $urlRecord->element;
            if (!$product) {
                \Log::warning('Product not found for URL record', ['slug' => $currentSlug]);
                return $this->fallbackProductUrl($currentSlug, $locale, $query);
            }

            // Получаем язык для новой локали
            $language = Language::where('code', $locale)->first();
            if (!$language) {
                \Log::warning('Language not found', ['locale' => $locale]);
                return $this->fallbackProductUrl($currentSlug, $locale, $query);
            }

            // Ищем URL для нужной локали
            $localizedUrlRecord = $product->urls()
                ->where('language_id', $language->id)
                ->first();

            if (!$localizedUrlRecord) {
                // Если нет URL для этой локали, берем дефолтный
                $localizedUrlRecord = $product->urls()
                    ->where('default', true)
                    ->first();
            }

            $newSlug = $localizedUrlRecord ? $localizedUrlRecord->slug : $currentSlug;

            \Log::info('Product URL found', [
                'original_slug' => $currentSlug,
                'new_slug' => $newSlug,
                'locale' => $locale,
                'product_id' => $product->id,
            ]);

            $newUrl = "/products/{$newSlug}";
            return $query ? "{$newUrl}?{$query}" : $newUrl;

        } catch (\Exception $e) {
            \Log::error('Error getting product URL', [
                'slug' => $currentSlug,
                'locale' => $locale,
                'error' => $e->getMessage(),
            ]);

            return $this->fallbackProductUrl($currentSlug, $locale, $query);
        }
    }

    /**
     * Fallback URL для продукта
     */
    private function fallbackProductUrl(string $slug, string $locale, string $query = ''): string
    {
        $url = "/products/{$slug}";
        return $query ? "{$url}?{$query}" : $url;
    }

    /**
     * Quick language switch для API или простых случаев
     */
    public function quickSwitch(string $locale, Request $request)
    {
        if (!in_array($locale, ['uk', 'en'])) {
            abort(404);
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        $redirectTo = $request->get('redirect_to', $request->header('referer', '/'));
        return redirect($this->getLocalizedUrl($redirectTo, $locale));
    }
}
