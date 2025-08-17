<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Livewire\AboutUsPage;
use App\Livewire\BlogPage;
use App\Livewire\BlogPostPage;
use App\Livewire\CatalogPage;
use App\Livewire\CollectionPage;
use App\Livewire\ContactsPage;
use App\Livewire\FaqPage;
use App\Livewire\Home;
use App\Livewire\ProductPage;
use App\Livewire\ReviewsPage;
use App\Livewire\SearchPage;
use App\Livewire\SubmitReview;
use App\Livewire\CheckoutPage;
use App\Livewire\CheckoutSuccessPage;
use Illuminate\Support\Facades\Route;

// 🔄 Переключение языка (вне группы локали)
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/switch/{locale}', [LanguageController::class, 'quickSwitch'])->name('lang.quick_switch');
Route::get('/products/{slug}', ProductPage::class)->name('product.view');

// 🌍 Группа маршрутов с префиксом локали
Route::group([
    'prefix' => '{locale?}',
    'where'  => ['locale' => 'en|uk'], // подставь свои коды языков
    'middleware' => ['localization'],
], function () {
    // Статика / разделы
    Route::get('/', Home::class)->name('home');
    Route::get('/catalog', CatalogPage::class)->name('catalog.view');
    Route::get('/reviews', ReviewsPage::class)->name('reviews');
    Route::get('/submit-review', SubmitReview::class)->name('submit-review');
    Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/faq', FaqPage::class)->name('faq');
    Route::get('/about-us', AboutUsPage::class)->name('about-us');
    Route::get('/contacts', ContactsPage::class)->name('contacts');

    // Блог
    Route::get('/blog', BlogPage::class)->name('blog.index');
    Route::get('/blog/{slug}', BlogPostPage::class)->name('blog.post');

    // Поиск / каталог
    Route::get('/search', SearchPage::class)->name('search.view');

    // Продукты и коллекции (slug-и из таблицы lunar_urls)
    Route::get('/products', SearchPage::class)->name('products.index');
    Route::get('/collections/{slug}', CollectionPage::class)->name('collection.view');

    // Чекаут
    Route::get('/checkout', CheckoutPage::class)->name('checkout.view');
    Route::get('/checkout/success', CheckoutSuccessPage::class)->name('checkout-success.view');
});
