<?php

use App\Livewire\AboutUsPage;
use App\Livewire\BlogPage;
use App\Livewire\CheckoutPage;
use App\Livewire\CheckoutSuccessPage;
use App\Livewire\ContactsPage;
use App\Livewire\FaqPage;
use App\Livewire\Home;
use App\Livewire\ReviewsPage;
use App\Livewire\SubmitReview;
use App\Livewire\SearchPage;
use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Livewire\UrlResolver;

// 🔄 Переключение языка
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/switch/{locale}', [\App\Http\Controllers\LanguageController::class, 'quickSwitch'])->name('lang.quick_switch');

// 🌍 Группа маршрутов с локалью
Route::group(['prefix' => '{locale?}', 'middleware' => ['localization']], function () {
    // Статические страницы
    Route::get('/', Home::class)->name('home');
    Route::get('/catalog', \App\Livewire\CatalogPage::class)->name('catalog.view');
    Route::get('/reviews', ReviewsPage::class)->name('reviews');
    Route::get('/submit-review', SubmitReview::class)->name('submit-review');
    Route::get('/privacy-policy', [\App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms', [\App\Http\Controllers\PageController::class, 'terms'])->name('terms');
    Route::get('/faq', FaqPage::class)->name('faq');
    Route::get('/about-us', AboutUsPage::class)->name('about-us');
    Route::get('/contacts', ContactsPage::class)->name('contacts');
    Route::get('/blog', BlogPage::class)->name('blog.index');
    Route::get('/search', SearchPage::class)->name('search.view');
    Route::get('/checkout', CheckoutPage::class)->name('checkout.view');
    Route::get('/checkout/success', CheckoutSuccessPage::class)->name('checkout-success.view');

    // 🪄 Универсальный роут для продуктов / коллекций / динамических страниц
    Route::get('/{slug}', UrlResolver::class)->name('url.resolver');
});
