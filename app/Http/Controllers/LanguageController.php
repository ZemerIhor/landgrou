<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (!in_array($locale, ['en', 'uk'])) {
            \Log::warning('Invalid locale attempted: ' . $locale);
            return Redirect::back()->with('error', 'Invalid locale');
        }

        // Сохраняем локаль в сессии
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Получаем текущий URL
        $redirectTo = request('redirect_to', URL::full());

        // Удаляем доменную часть
        $baseUrl = config('app.url');
        $path = str_replace($baseUrl, '', $redirectTo);

        // Удаляем префикс языка, если он есть
        $path = preg_replace('#^/(en|uk)/#', '/', $path);

        // Если это страница продукта, получаем правильный слаг
        if (preg_match('#^/products/([^/]+)#', $path, $matches)) {
            $currentSlug = $matches[1];
            // Находим продукт по текущему слагу
            $url = \Lunar\Models\Url::where('slug', $currentSlug)
                ->where('element_type', \Lunar\Models\Product::class)
                ->first();

            if ($url) {
                $product = $url->element;
                $newUrl = $product->urls()
                    ->where('language_id', \Lunar\Models\Language::where('code', $locale)->first()->id ?? 1)
                    ->first();

                if ($newUrl) {
                    $path = "/products/{$newUrl->slug}";
                }
            }
        }

        // Логируем для отладки
        \Log::info('Language switch requested', [
            'locale' => $locale,
            'redirect_to' => $path,
            'current_url' => URL::full(),
            'request_path' => request()->path(),
        ]);

        // Добавляем query-параметры, если они есть
        $query = parse_url($redirectTo, PHP_URL_QUERY);
        if ($query) {
            $path .= '?' . $query;
        }

        return redirect($path ?: '/');
    }
}
