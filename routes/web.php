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

// Маршрут для смены языка через контроллер
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

// Быстрое переключение языка
Route::get('/switch/{locale}', [\App\Http\Controllers\LanguageController::class, 'quickSwitch'])->name('lang.quick_switch');

// Маршрут для страниц продуктов (без префикса локали)
Route::get('/products/{slug}', ProductPage::class)->name('product.view')->middleware(['localization']);

// Группа маршрутов с префиксом локали
Route::group(['prefix' => '{locale?}', 'middleware' => ['localization']], function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/catalog', CatalogPage::class)->name('catalog.view');
    Route::get('/reviews', \App\Livewire\ReviewsPage::class)->name('reviews');
    Route::get('/submit-review', \App\Livewire\SubmitReview::class)->name('submit-review');
    Route::get('/privacy-policy', [\App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms', [\App\Http\Controllers\PageController::class, 'terms'])->name('terms');
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
