<?php
// routes/web.php
use App\Livewire\BlogPage;
use App\Livewire\BlogPostPage;
use App\Livewire\CheckoutPage;
use App\Livewire\CheckoutSuccessPage;
use App\Livewire\CollectionPage;
use App\Livewire\Home;
use App\Livewire\ProductPage;
use App\Livewire\SearchPage;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);

Route::get('/blog', BlogPage::class)->name('blog.index');
Route::get('/blog/{slug}', BlogPostPage::class)->name('blog.post');
Route::get('/collections/{slug}', CollectionPage::class)->name('collection.view');

Route::get('/products/{slug}', ProductPage::class)->name('product.view');

Route::get('search', SearchPage::class)->name('search.view');

Route::get('checkout', CheckoutPage::class)->name('checkout.view');

Route::get('checkout/success', CheckoutSuccessPage::class)->name('checkout-success.view');
Route::get('/products', SearchPage::class)->name('products.index');
Route::get('/lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('page.show');

