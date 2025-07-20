<?php

use App\Livewire\AboutUsPage;
use App\Livewire\BlogPage;
use App\Livewire\BlogPostPage;
use App\Livewire\CatalogPage;
use App\Livewire\CheckoutPage;
use App\Livewire\CheckoutSuccessPage;
use App\Livewire\CollectionPage;
use App\Livewire\ContactsPage;
use App\Livewire\FaqPage;
use App\Livewire\Home;
use App\Livewire\ProductPage;
use App\Livewire\SearchPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

// Явное переключение языка с редиректом
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['uk', 'en'])) {
        abort(404);
    }

    Session::put('locale', $locale);
    App::setLocale($locale);

    $redirectTo = request()->query('redirect_to', '/');

    // Удаляем префикс локали из redirect_to, если он есть
    $redirectTo = preg_replace('#^/(en|uk)/#', '/', $redirectTo);

    return redirect($redirectTo);
})->name('lang.switch');

// Быстрое переключение языка
Route::get('/switch/{locale}', function ($locale) {
    if (!in_array($locale, ['uk', 'en'])) {
        abort(404);
    }

    Session::put('locale', $locale);
    App::setLocale($locale);

    // Получаем текущий URL без префикса локали
    $currentPath = preg_replace('#^/(en|uk)/#', '/', request()->path());
    return redirect($currentPath);
})->name('lang.quick_switch');

// Маршруты без префикса локали для продуктов
Route::get('/products/{slug}', ProductPage::class)->name('product.view')->middleware('localization');

// Группа маршрутов с префиксом языка (опционально) для остальных страниц
Route::group(['prefix' => '{locale?}', 'middleware' => ['localization']], function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/catalog', CatalogPage::class)->name('catalog.view');
    Route::get('/reviews', \App\Livewire\ReviewsPage::class)->name('reviews');
    Route::get('/submit-review', \App\Livewire\SubmitReview::class)->name('submit-review');
    Route::get('/privacy-policy', fn () => 'Hello World')->name('privacy-policy');
    Route::get('/terms', fn () => 'Hello World')->name('terms');
    Route::get('/faq', FaqPage::class)->name('faq');
    Route::get('/about-us', AboutUsPage::class)->name('about-us');
    Route::get('/contacts', ContactsPage::class)->name('contacts');
    Route::get('/blog', BlogPage::class)->name('blog.index');
    Route::get('/blog/{slug}', BlogPostPage::class)->name('blog.post');
    Route::get('/collections/{slug}', CollectionPage::class)->name('collection.view');
    Route::get('/search', SearchPage::class)->name('search.view');
    Route::get('/checkout', CheckoutPage::class)->name('checkout.view');
    Route::get('/checkout/success', CheckoutSuccessPage::class)->name('checkout-success.view');
    Route::get('/products', SearchPage::class)->name('products.index');
});
