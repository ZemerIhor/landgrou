<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    public function handle($request, Closure $next)
    {
        // Приоритет: ?lang=uk → session → config
        $currentLocale = Session::get('locale', config('app.locale'));
        $locale = $request->get('lang', $currentLocale);

        if (!in_array($locale, ['en', 'uk'])) {
            $locale = 'en';
        }

        // Установка языка
        App::setLocale($locale);

        // Обновляем сессию, если локаль изменилась
        if ($locale !== $currentLocale) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
