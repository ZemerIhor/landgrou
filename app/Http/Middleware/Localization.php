<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);

        if (in_array($locale, ['en', 'uk'])) {
            // Locale is provided in URL (e.g., /en/...)
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // No locale in URL (e.g., /products/{slug}), use session or fallback
            $locale = Session::get('locale', config('app.locale', 'en'));
            App::setLocale($locale);
        }

        return $next($request);
    }
}
