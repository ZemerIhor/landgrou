<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationHelper
{
    /**
     * Поддерживаемые локали
     */
    private const SUPPORTED_LOCALES = ['en', 'uk'];

    /**
     * Получить текущую локаль
     */
    public static function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    /**
     * Получить все поддерживаемые локали
     */
    public static function getSupportedLocales(): array
    {
        return self::SUPPORTED_LOCALES;
    }

    /**
     * Проверить, поддерживается ли локаль
     */
    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::SUPPORTED_LOCALES);
    }

    /**
     * Получить локаль из URL или сессии
     */
    public static function detectLocale(?string $urlLocale = null): string
    {
        if ($urlLocale && self::isSupported($urlLocale)) {
            return $urlLocale;
        }

        $sessionLocale = Session::get('locale');
        if ($sessionLocale && self::isSupported($sessionLocale)) {
            return $sessionLocale;
        }

        $browserLocale = self::getBrowserLocale();
        if ($browserLocale && self::isSupported($browserLocale)) {
            return $browserLocale;
        }

        return config('app.locale', 'en');
    }

    /**
     * Установить локаль приложения
     */
    public static function setLocale(string $locale): bool
    {
        if (!self::isSupported($locale)) {
            return false;
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return true;
    }

    /**
     * Получить локаль из заголовков браузера
     */
    public static function getBrowserLocale(): ?string
    {
        $acceptLanguage = request()->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }

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

        arsort($languages);

        foreach (array_keys($languages) as $locale) {
            if (self::isSupported($locale)) {
                return $locale;
            }
            
            $mainLocale = explode('-', $locale)[0];
            if (self::isSupported($mainLocale)) {
                return $mainLocale;
            }
        }

        return null;
    }

    /**
     * Получить URL с локалью
     */
    public static function getLocalizedUrl(string $locale, ?string $path = null): string
    {
        if (!self::isSupported($locale)) {
            $locale = config('app.locale', 'en');
        }

        $path = $path ?: request()->path();
        
        $path = preg_replace('#^/(en|uk)/?#', '/', $path);
        
        $localizedPath = "/{$locale}" . ($path === '/' ? '' : $path);
        
        return url($localizedPath);
    }

    /**
     * Получить все локализованные URL для текущей страницы
     */
    public static function getAllLocalizedUrls(?string $path = null): array
    {
        $urls = [];
        
        foreach (self::SUPPORTED_LOCALES as $locale) {
            $urls[$locale] = self::getLocalizedUrl($locale, $path);
        }
        
        return $urls;
    }

    /**
     * Получить название локали на родном языке
     */
    public static function getLocaleName(string $locale): string
    {
        return match ($locale) {
            'en' => 'English',
            'uk' => 'Українська',
            default => $locale,
        };
    }

    /**
     * Получить флаг локали
     */
    public static function getLocaleFlag(string $locale): string
    {
        return match ($locale) {
            'en' => '🇺🇸',
            'uk' => '🇺🇦',
            default => '🌐',
        };
    }

    /**
     * Получить направление текста для локали
     */
    public static function getTextDirection(string $locale): string
    {
        return 'ltr';
    }

    /**
     * Получить переведенное значение из JSON поля
     */
    public static function getTranslatedValue(mixed $jsonField, ?string $locale = null, ?string $fallback = null): ?string
    {
        $locale = $locale ?: self::getCurrentLocale();
        $fallback = $fallback ?: config('app.fallback_locale', 'en');

        if (is_string($jsonField)) {
            return $jsonField;
        }

        if (is_array($jsonField)) {
            if (isset($jsonField[$locale])) {
                return $jsonField[$locale];
            }
            
            if (isset($jsonField[$fallback])) {
                return $jsonField[$fallback];
            }
            
            return reset($jsonField) ?: null;
        }

        return null;
    }

    /**
     * Создать переводимый массив
     */
    public static function createTranslatableArray(string $value, ?array $locales = null): array
    {
        $locales = $locales ?: self::SUPPORTED_LOCALES;
        $translatable = [];
        
        foreach ($locales as $locale) {
            $translatable[$locale] = $value;
        }
        
        return $translatable;
    }

    /**
     * Проверить, заполнено ли переводимое поле
     */
    public static function isTranslatableFieldFilled(mixed $jsonField, ?string $locale = null): bool
    {
        $value = self::getTranslatedValue($jsonField, $locale);
        return !empty(trim($value ?? ''));
    }

    /**
     * Получить процент заполненности переводов
     */
    public static function getTranslationCompleteness(array $translatableFields): array
    {
        $stats = [];
        
        foreach (self::SUPPORTED_LOCALES as $locale) {
            $total = count($translatableFields);
            $filled = 0;
            
            foreach ($translatableFields as $field) {
                if (self::isTranslatableFieldFilled($field, $locale)) {
                    $filled++;
                }
            }
            
            $stats[$locale] = [
                'filled' => $filled,
                'total' => $total,
                'percentage' => $total > 0 ? round(($filled / $total) * 100, 1) : 0,
            ];
        }
        
        return $stats;
    }

    /**
     * Получить метаданные для текущей локали
     */
    public static function getCurrentLocaleMetadata(): array
    {
        $locale = self::getCurrentLocale();
        
        return [
            'code' => $locale,
            'name' => self::getLocaleName($locale),
            'flag' => self::getLocaleFlag($locale),
            'direction' => self::getTextDirection($locale),
            'is_default' => $locale === config('app.locale'),
        ];
    }
}
