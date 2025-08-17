<?php

namespace App\Http\Middleware;

use App\Services\LanguageService;
use Closure;
use Illuminate\Http\Request;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Language;
use Lunar\Models\Product;

class Localization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $languageService = app(LanguageService::class);
        $urlLocale = $request->segment(1);

        \Log::info('Localization middleware started', [
            'url_locale' => $urlLocale,
            'path' => $request->path(),
            'full_url' => $request->fullUrl(),
            'session_locale' => session('locale'),
        ]);

        // Определяем локаль
        $detectedLocale = $this->detectLocale($request, $languageService, $urlLocale);

        // Устанавливаем локаль через сервис
        $languageService->setLocale($detectedLocale);

        \Log::info('Localization middleware completed', [
            'url_locale' => $urlLocale,
            'detected_locale' => $detectedLocale,
            'final_locale' => $languageService->getCurrentLocale(),
            'path' => $request->path(),
        ]);

        return $next($request);
    }

    /**
     * Определить локаль на основе запроса
     */
    private function detectLocale(Request $request, LanguageService $languageService, ?string $urlLocale): string
    {
        // Если это страница продукта (/products/*), используем специальную логику
        if ($request->is('products/*')) {
            return $this->detectLocaleForProduct($request, $languageService);
        }

        // Для остальных маршрутов используем обычную логику определения локали
        return $languageService->detectLocale($urlLocale);
    }

    /**
     * Определить локаль для страницы продукта
     */
    private function detectLocaleForProduct(Request $request, LanguageService $languageService): string
    {
        $currentPath = $request->path();

        // Получаем slug продукта
        if (!preg_match('#^products/([^/]+)$#', $currentPath, $matches)) {
            return session('locale', config('app.locale', 'en'));
        }

        $currentSlug = $matches[1];

        \Log::info('Product locale detection', [
            'slug' => $currentSlug,
            'session_locale' => session('locale'),
        ]);

        try {
            // Находим URL запись по slug
            $urlRecord = LunarUrl::where('slug', $currentSlug)
                ->where('element_type', Product::class)
                ->first();

            if (!$urlRecord) {
                \Log::warning('Product URL record not found', ['slug' => $currentSlug]);
                return session('locale', config('app.locale', 'en'));
            }

            // Получаем язык URL записи
            $language = Language::find($urlRecord->language_id);
            if (!$language) {
                \Log::warning('Language not found for URL record', [
                    'slug' => $currentSlug,
                    'language_id' => $urlRecord->language_id,
                ]);
                return session('locale', config('app.locale', 'en'));
            }

            \Log::info('Product language detected', [
                'slug' => $currentSlug,
                'detected_locale' => $language->code,
            ]);

            // Устанавливаем локаль в сессии, если она отличается
            if (session('locale') !== $language->code) {
                session(['locale' => $language->code]);
                \Log::info('Updated session locale', [
                    'old_locale' => session('locale'),
                    'new_locale' => $language->code,
                ]);
            }

            return $language->code;

        } catch (\Exception $e) {
            \Log::error('Error detecting product locale', [
                'slug' => $currentSlug,
                'error' => $e->getMessage(),
            ]);

            return session('locale', config('app.locale', 'en'));
        }
    }
}
