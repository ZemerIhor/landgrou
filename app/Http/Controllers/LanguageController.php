<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Lunar\Models\Product;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (!in_array($locale, ['en', 'uk'])) {
            \Log::warning('Invalid locale attempted: ' . $locale);
            return Redirect::back()->with('error', 'Invalid locale');
        }

        // Save locale to session
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Get current URL
        $redirectTo = request('redirect_to', URL::full());

        // Remove domain part
        $baseUrl = config('app.url');
        $path = str_replace($baseUrl, '', $redirectTo);

        // Remove locale prefix, if present
        $path = preg_replace('#^/(en|uk)/#', '/', $path);

        // Handle product URLs
        if (preg_match('#^/products/([^/]+)#', $path, $matches)) {
            $currentSlug = $matches[1];

            // Find the product by slug
            $url = Url::where('slug', $currentSlug)
                ->where('element_type', Product::class)
                ->first();

            if (!$url) {
                // Check alternative slug (e.g., Ukrainian version)
                $url = Url::where('slug', $currentSlug . 'vfv')
                    ->where('element_type', Product::class)
                    ->first();
            }

            if ($url) {
                $product = $url->element;
                // Get the slug for the new locale
                $newUrl = $product->urls()
                    ->where('language_id', \Lunar\Models\Language::where('code', $locale)->first()->id ?? 1)
                    ->first();

                if ($newUrl) {
                    $path = "/products/{$newUrl->slug}";
                }
            }
        }

        // Log for debugging
        \Log::info('Language switch requested', [
            'locale' => $locale,
            'redirect_to' => $path,
            'current_url' => URL::full(),
            'request_path' => request()->path(),
        ]);

        // Add query parameters, if present
        $query = parse_url($redirectTo, PHP_URL_QUERY);
        if ($query) {
            $path .= '?' . $query;
        }

        return redirect($path ?: '/');
    }
}
