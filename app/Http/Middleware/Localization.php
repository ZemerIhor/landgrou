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
            App::setLocale($locale);
            session(['locale' => $locale]);
        } else {
            App::setLocale(session('locale', config('app.locale')));
        }

        return $next($request);
    }
}
