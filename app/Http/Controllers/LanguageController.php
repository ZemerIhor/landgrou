<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Lunar\Models\Product;
use Lunar\Models\Language;

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

        // Обрабатываем страницы продуктов (без префикса локали)
        if (preg_match('#^/products/([^/]+)#', $path, $matches)) {
            $currentSlug = $matches[1];

            // Находим URL по текущему слагу
            $url = Url::where('slug', $currentSlug)
                ->where('element_type', Product::class)
                ->first();

            if (!$url) {
                // Проверяем альтернативный слаг (например, украинский с 'vfv')
                $url = Url::where('slug', $currentSlug . 'vfv')
                    ->orWhere('slug', str_replace('vfv', '', $currentSlug))
                    ->where('element_type', Product::class)
                    ->first();
            }

            if ($url) {
                $product = $url->element;
                // Получаем ID языка для новой локали
                $languageId = Language::where('code', $locale)->first()->id ?? 1;
                // Получаем новый URL для локали
                $newUrl = $product->urls()
                    ->where('language_id', $languageId)
                    ->first();

                if ($newUrl) {
                    $path = "/products/{$newUrl->slug}";
                } else {
                    // Фоллбек: используем дефолтный слаг
                    $path = "/products/{$product->slug}";
                }
            } else {
                // Если продукт не найден, редирект на главную
                $path = '/';
            }
        } else {
            // Для других страниц добавляем префикс локали
            $path = "/{$locale}/{$path}";
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
