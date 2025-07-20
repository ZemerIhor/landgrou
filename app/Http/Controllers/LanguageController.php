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
        // Проверяем, что локаль допустима
        if (!in_array($locale, ['en', 'uk'])) {
            \Log::warning('Invalid locale attempted: ' . $locale);
            return Redirect::back()->with('error', 'Invalid locale');
        }

        // Сохраняем локаль в сессии
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Получаем текущий URL из параметра redirect_to или текущего запроса
        $redirectTo = request('redirect_to', URL::full());

        // Логируем для отладки
        \Log::info('Language switch requested', [
            'locale' => $locale,
            'redirect_to' => $redirectTo,
            'current_url' => URL::full(),
            'request_path' => request()->path(),
        ]);

        // Удаляем доменную часть, оставляем только путь
        $baseUrl = config('app.url');
        $path = str_replace($baseUrl, '', $redirectTo);

        // Удаляем текущий префикс языка, если он есть
        $segments = explode('/', ltrim($path, '/'));
        if (in_array($segments[0] ?? '', ['en', 'uk'])) {
            array_shift($segments);
        }

        // Формируем новый путь
        $newPath = implode('/', $segments);
        if (empty($newPath)) {
            $newPath = request()->path(); // Используем текущий путь запроса
        }

        // Формируем финальный URL
        $finalUrl = $locale === 'en' ? '/en' . ($newPath ? '/' . $newPath : '') : '/' . $newPath;

        // Добавляем query-параметры, если они есть
        $query = parse_url($redirectTo, PHP_URL_QUERY);
        if ($query) {
            $finalUrl .= '?' . $query;
        }

        // Логируем финальный URL
        \Log::info('Redirecting to: ' . $finalUrl);

        return redirect($finalUrl ?: '/');
    }
}
