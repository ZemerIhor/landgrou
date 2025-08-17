<?php

namespace App\Http\Middleware;

use App\Services\LanguageService;
use Closure;
use Illuminate\Http\Request;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Language;

class Localization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $languageService = app(LanguageService::class);
        $urlLocale = $request->segment(1);

        // Если это страница продукта (/products/*), используем локаль из сессии
        if ($request->is('products/*')) {
            $detectedLocale = session('locale', config('app.locale', 'en'));

            // Проверяем, соответствует ли текущий slug локали
            $currentPath = $request->path();
            if (preg_match('#^products/([^/]+)$#', $currentPath, $matches)) {
                $currentSlug = $matches[1];
                $urlRecord = LunarUrl::where('slug', $currentSlug)
                    ->where('element_type', 'product')
                    ->first();

                if ($urlRecord) {
                    $product = $urlRecord->element;
                    $language = Language::where('code', $detectedLocale)->first();
                    $correctUrl = $product->urls()
                        ->where('language_id', $language?->id)
                        ->first()
                        ?? $product->urls()->where('default', true)->first();

                    // Если текущий slug не соответствует локали, перенаправляем
                    if ($correctUrl && $correctUrl->slug !== $currentSlug) {
                        return redirect("/products/{$correctUrl->slug}");
                    }
                }
            }
        } else {
            // Для остальных маршрутов используем обычную логику определения локали
            $detectedLocale = $languageService->detectLocale($urlLocale);
        }

        // Устанавливаем локаль через сервис
        $languageService->setLocale($detectedLocale);

        \Log::info('Localization Middleware', [
            'url_locale' => $urlLocale,
            'detected_locale' => $detectedLocale,
            'final_locale' => $languageService->getCurrentLocale(),
            'path' => $request->path(),
        ]);

        return $next($request);
    }
}
