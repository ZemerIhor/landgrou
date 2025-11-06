<?php

namespace App\Http\Middleware;

use App\Services\LanguageService;
use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $excludedPaths = [
            'lunar/*',
            'livewire/*',
            'api/*',
            '_debugbar/*',
            'storage/*',
            'stripe/*',
            'passkeys/*',
        ];
        
        foreach ($excludedPaths as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        $languageService = app(LanguageService::class);
        
        $urlLocale = $request->segment(1);
        $detectedLocale = $languageService->detectLocale($urlLocale);
        
        if ((!$urlLocale || !$languageService->isValidLocale($urlLocale)) && $request->path() !== '/') {
            $currentPath = $request->path();
            if (!preg_match('#^(en|uk)/#', $currentPath)) {
                return redirect("/{$detectedLocale}/{$currentPath}");
            }
        }
        
        $languageService->setLocale($detectedLocale);

        if (config('app.debug')) {
            \Log::debug('Localization Middleware', [
                'url_locale' => $urlLocale,
                'detected_locale' => $detectedLocale,
                'final_locale' => $languageService->getCurrentLocale(),
                'path' => $request->path(),
            ]);
        }

        return $next($request);
    }
}
