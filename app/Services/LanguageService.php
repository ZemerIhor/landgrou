<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Lunar\Models\Url as LunarUrl;
use Lunar\Models\Product;
use Lunar\Models\Language;

class LanguageService
{
    private const SUPPORTED_LOCALES = ['en', 'uk'];

    /**
     * Переключение языка приложения
     */
    public function switchLanguage(string $locale, ?string $redirectTo = null): string
    {
        if (!$this->isValidLocale($locale)) {
            Log::warning('Попытка использовать неподдерживаемую локаль: ' . $locale);
            throw new \InvalidArgumentException('Неподдерживаемая локаль');
        }

        $this->setLocale($locale);
        $redirectTo = $redirectTo ?: request()->fullUrl();

        $path = $this->processRedirectPath($redirectTo, $locale);

        Log::info('Переключение языка', [
            'locale' => $locale,
            'redirect_to' => $path,
            'current_url' => $redirectTo,
        ]);

        return $path;
    }

    /**
     * Проверка валидности локали
     */
    public function isValidLocale(string $locale): bool
    {
        return in_array($locale, self::SUPPORTED_LOCALES);
    }

    /**
     * Определение локали из URL или сессии
     */
    public function detectLocale(?string $urlLocale = null): string
    {
        // Проверяем локаль из URL
        if ($urlLocale && $this->isValidLocale($urlLocale)) {
            return $urlLocale;
        }

        // Проверяем локаль из сессии
        $sessionLocale = Session::get('locale');
        if ($sessionLocale && $this->isValidLocale($sessionLocale)) {
            return $sessionLocale;
        }

        // Проверяем заголовки браузера
        $browserLocale = $this->getBrowserLocale();
        if ($browserLocale && $this->isValidLocale($browserLocale)) {
            return $browserLocale;
        }

        // Возвращаем дефолтную локаль
        return config('app.locale', 'en');
    }

    /**
     * Установка локали приложения
     */
    public function setLocale(string $locale): bool
    {
        if (!$this->isValidLocale($locale)) {
            return false;
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        return true;
    }

    /**
     * Получение локали из заголовков браузера
     */
    private function getBrowserLocale(): ?string
    {
        $acceptLanguage = request()->header('Accept-Language');

        if (!$acceptLanguage) {
            return null;
        }

        // Парсим заголовок Accept-Language
        $languages = [];
        foreach (explode(',', $acceptLanguage) as $lang) {
            $parts = explode(';', trim($lang));
            $locale = trim($parts[0]);
            $quality = 1.0;

            if (isset($parts[1]) && str_starts_with(trim($parts[1]), 'q=')) {
                $quality = (float) substr(trim($parts[1]), 2);
            }

            $languages[$locale] = $quality;
        }

        // Сортируем по приоритету
        arsort($languages);

        // Ищем поддерживаемую локаль
        foreach (array_keys($languages) as $locale) {
            if ($this->isValidLocale($locale)) {
                return $locale;
            }

            $mainLocale = explode('-', $locale)[0];
            if ($this->isValidLocale($mainLocale)) {
                return $mainLocale;
            }
        }

        return null;
    }

    /**
     * Обработка пути перенаправления при смене локали
     */
    private function processRedirectPath(string $redirectTo, string $locale): string
    {
        $baseUrl = config('app.url');
        $path = str_replace($baseUrl, '', $redirectTo);
        $path = $this->removeLocalePrefix($path);

        if ($this->isProductPage($path)) {
            return $this->handleProductPageLocale($path, $locale);
        }

        return $this->handleRegularPageLocale($path, $locale);
    }

    /**
     * Удаление префикса локали из пути
     */
    private function removeLocalePrefix(string $path): string
    {
        return preg_replace('#^/(en|uk)/#', '/', $path);
    }

    /**
     * Проверка, является ли путь страницей продукта
     */
    private function isProductPage(string $path): bool
    {
        return preg_match('#^/products/([^/]+)#', $path);
    }

    /**
     * Обработка локали для страницы продукта
     */
    private function handleProductPageLocale(string $path, string $locale): string
    {
        preg_match('#^/products/([^/]+)#', $path, $matches);
        $currentSlug = $matches[1];

        $url = $this->findProductUrl($currentSlug);

        Log::info('handleProductPageLocale', [
            'current_slug' => $currentSlug,
            'locale' => $locale,
            'url' => $url ? $url->toArray() : null,
        ]);

        if (!$url) {
            Log::warning('Продукт не найден для слага: ' . $currentSlug);
            return "/{$locale}";
        }

        $newUrl = $this->getProductUrlForLocale($url->element, $locale);

        if ($newUrl) {
            return "/products/{$newUrl->slug}";
        }

        // Fallback на дефолтный слаг
        return "/products/{$url->element->slug}";
    }

    /**
     * Обработка локали для обычных страниц
     */
    private function handleRegularPageLocale(string $path, string $locale): string
    {
        $newPath = "/{$locale}{$path}";

        if ($this->routeExists($newPath)) {
            return $newPath;
        }

        Log::warning('Маршрут не найден для пути: ' . $newPath);
        return "/{$locale}";
    }

    /**
     * Поиск URL продукта по слагу
     */
    private function findProductUrl(string $slug): ?LunarUrl
    {
        $url = LunarUrl::where('slug', $slug)
            ->where('element_type', Product::class) // Используем полное имя класса
            ->first();

        Log::info('findProductUrl result', [
            'slug' => $slug,
            'url' => $url ? $url->toArray() : null,
            'element_type' => Product::class,
        ]);

        return $url;
    }

    /**
     * Получение URL продукта для конкретной локали
     */
    private function getProductUrlForLocale(Product $product, string $locale): ?LunarUrl
    {
        $languageId = Language::where('code', $locale)->first()?->id ?? 1;

        // Используем прямой запрос к LunarUrl вместо $product->urls()
        $url = LunarUrl::where('element_id', $product->id)
            ->where('element_type', Product::class)
            ->where('language_id', $languageId)
            ->first();

        // Если не найден URL для конкретной локали, ищем дефолтный
        if (!$url) {
            $url = LunarUrl::where('element_id', $product->id)
                ->where('element_type', Product::class)
                ->where('default', true)
                ->first();
        }

        Log::info('getProductUrlForLocale', [
            'product_id' => $product->id,
            'locale' => $locale,
            'language_id' => $languageId,
            'url' => $url ? $url->toArray() : null,
        ]);

        return $url;
    }

    /**
     * Проверка существования маршрута
     */
    private function routeExists(string $path): bool
    {
        try {
            Route::getRoutes()->match(
                \Illuminate\Http\Request::create($path, 'GET')
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Добавление параметров запроса к пути
     */
    public function addQueryParameters(string $path, string $originalUrl): string
    {
        $query = parse_url($originalUrl, PHP_URL_QUERY);

        if ($query) {
            $path .= '?' . $query;
        }

        return $path;
    }

    /**
     * Получение поддерживаемых локалей
     */
    public function getSupportedLocales(): array
    {
        return self::SUPPORTED_LOCALES;
    }

    /**
     * Получение текущей локали
     */
    public function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    /**
     * Получение локали из запроса
     */
    public function getLocaleFromRequest(): string
    {
        $locale = request()->segment(1);

        if ($this->isValidLocale($locale)) {
            return $locale;
        }

        return Session::get('locale', config('app.locale', 'en'));
    }
}
