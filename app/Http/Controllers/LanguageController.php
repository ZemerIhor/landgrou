<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL as FacadeURL;

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

        $currentPath = preg_replace('#^/(en|uk)/#', '/', request()->path());
        return redirect("/{$locale}/{$currentPath}");
    }
}
