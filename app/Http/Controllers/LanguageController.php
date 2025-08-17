<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL as FacadeURL;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Language;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(string $locale)
    {
        $languageService = app(LanguageService::class);

        try {
            $redirectTo = request('redirect_to', FacadeURL::full());
            $path = $languageService->switchLanguage($locale, $redirectTo);
            $path = $languageService->addQueryParameters($path, $redirectTo);

            return redirect($path ?: "/{$locale}");
        } catch (\InvalidArgumentException $e) {
            return Redirect::back()->with('error', 'Invalid locale');
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
     * Quick language switch for simple cases
     */
    public function quickSwitch(string $locale)
    {
        if (!in_array($locale, ['uk', 'en'])) {
            abort(404);
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        $currentPath = request()->path();
        if (preg_match('#^products/([^/]+)$#', $currentPath, $matches)) {
            $currentSlug = $matches[1];
            $urlRecord = LunarUrl::where('slug', $currentSlug)
                ->where('element_type', 'product')
                ->first();

            if ($urlRecord) {
                $product = $urlRecord->element;
                $language = Language::where('code', $locale)->first();
                $newUrlRecord = $product->urls()->where('language_id', $language?->id)->first()
                    ?? $product->urls()->where('default', true)->first();
                return redirect('/products/' . ($newUrlRecord->slug ?? $currentSlug));
            }
        }

        $currentPath = preg_replace('#^/(en|uk)/#', '/', $currentPath);
        return redirect("/{$locale}/{$currentPath}");
    }
}
