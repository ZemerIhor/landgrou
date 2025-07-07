<?php

namespace App\Providers;

use App\Filament\Pages\AboutUs;
use App\Filament\Pages\Contacts;
use App\Filament\Pages\Faq;
use App\Filament\Pages\Footer;
use App\Filament\Pages\Header;
use App\Filament\Pages\Home;
use App\Filament\Resources\BlogPostResource;
use App\Filament\Resources\ReviewResource;
use App\Livewire\Components\Breadcrumbs;
use App\Livewire\Elements\PromoBoxElement;
use App\Modifiers\ShippingModifier;
use Filament\SpatieLaravelTranslatablePlugin;
use Geosem42\Filamentor\FilamentorPlugin;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kenepa\TranslationManager\TranslationManagerPlugin;
use Lunar\Admin\Support\Facades\LunarPanel;
use Lunar\Base\ShippingModifiers;
use Lunar\Shipping\ShippingPlugin;
use SolutionForest\FilamentTranslateField\FilamentTranslateFieldPlugin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        LunarPanel::panel(
            fn($panel) => $panel
                ->pages([
                    Footer::class, // 👈 добавляем сюда
                    Home::class,
                    Header::class, // Регистрируем страницу Header
                    Faq::class, // Регистрируем страницу Header
                    Contacts::class, // Регистрируем страницу Header
                    AboutUs::class, // Регистрируем страницу Header
                ])
                ->resources([
                    BlogPostResource::class,
                    ReviewResource::class,
                ])
                ->plugins([
                    new ShippingPlugin,
//                    FilamentorPlugin::make(),
                    \Biostate\FilamentMenuBuilder\FilamentMenuBuilderPlugin::make(),
                    FilamentTranslateFieldPlugin::make()
                        ->defaultLocales(['en', 'uk'])
                ])
        )->register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ShippingModifiers $shippingModifiers): void
    {

        $shippingModifiers->add(
            ShippingModifier::class
        );
        \Lunar\Facades\ModelManifest::replace(
            \Lunar\Models\Contracts\Product::class,
            \App\Models\Product::class,
        // \App\Models\CustomProduct::class,
        );
    }
}
