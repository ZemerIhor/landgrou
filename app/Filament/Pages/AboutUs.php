<?php

namespace App\Filament\Pages;

use App\Settings\AboutUsSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AboutUs extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static string $view = 'filament.pages.about-us';

    protected static string $settings = AboutUsSettings::class;

    protected static ?string $navigationLabel = 'About Us Settings';

    public static function getSlug(): string
    {
        return 'about-us';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(AboutUsSettings::class);

        $this->data = [
            'hero_background_image' => $settings->hero_background_image,
            'hero_background_image_alt' => $settings->hero_background_image_alt,
            'hero_logo' => $settings->hero_logo,
            'hero_logo_alt' => $settings->hero_logo_alt,
            'hero_title' => $settings->hero_title,
            'hero_subtitle' => $settings->hero_subtitle,
            'hero_subtitle_highlight' => $settings->hero_subtitle_highlight,
            'hero_slogan' => $settings->hero_slogan,
            'hero_description' => $settings->hero_description,
            'advantages' => $settings->advantages,
            'advantage_images' => $settings->advantage_images,
            'about_title' => $settings->about_title,
            'about_description' => $settings->about_description,
            'gallery_title' => $settings->gallery_title,
            'gallery_images' => $settings->gallery_images,
            'certificates_title' => $settings->certificates_title,
            'certificates_images' => $settings->certificates_images,
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('About Us Page'))
                    ->schema([
                        // Images Section (outside Translate)
                        Section::make(__('Images'))
                            ->schema([
                                // Hero Images
                                FileUpload::make('hero_background_image')
                                    ->label(__('Hero Background Image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('about-us/hero'),
                                FileUpload::make('hero_logo')
                                    ->label(__('Hero Logo'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('about-us/logo'),
                                // Advantage Images
                                Repeater::make('advantage_images')
                                    ->label(__('Advantage Images'))
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label(__('Image'))
                                            ->image()
                                            ->disk('public')
                                            ->directory('about-us/advantages'),
                                    ])
                                    ->columns(1)
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(3)
                                    ->maxItems(3),
                                // Gallery Images
                                Repeater::make('gallery_images')
                                    ->label(__('Gallery Images'))
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label(__('Image'))
                                            ->image()
                                            ->disk('public')
                                            ->directory('about-us/gallery'),
                                    ])
                                    ->columns(1)
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(5),
                                // Certificates Images
                                Repeater::make('certificates_images')
                                    ->label(__('Certificates Images'))
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label(__('Image'))
                                            ->image()
                                            ->disk('public')
                                            ->directory('about-us/certificates'),
                                    ])
                                    ->columns(1)
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(5),
                            ])
                            ->collapsible(),

                        // Translated Content
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                // Hero Section
                                Section::make(__('Hero Section'))
                                    ->schema([
                                        TextInput::make('hero_background_image_alt')
                                            ->label(__('Hero Background Image Alt Text'))
                                            ->rules(['nullable', 'max:255']),
                                        TextInput::make('hero_logo_alt')
                                            ->label(__('Hero Logo Alt Text'))
                                            ->rules(['nullable', 'max:255']),
                                        TextInput::make('hero_title')
                                            ->label(__('Hero Title'))
                                            ->rules(['nullable', 'max:255']),
                                        TextInput::make('hero_subtitle')
                                            ->label(__('Hero Subtitle'))
                                            ->rules(['nullable', 'max:255']),
                                        TextInput::make('hero_subtitle_highlight')
                                            ->label(__('Hero Subtitle Highlighted Word'))
                                            ->rules(['nullable', 'max:100']),
                                        TextInput::make('hero_slogan')
                                            ->label(__('Hero Slogan'))
                                            ->rules(['nullable', 'max:100']),
                                        Textarea::make('hero_description')
                                            ->label(__('Hero Description'))
                                            ->rules(['nullable']),
                                    ])
                                    ->collapsible(),

                                // Advantages Section
                                Section::make(__('Advantages Section'))
                                    ->schema([
                                        Repeater::make('advantages')
                                            ->label(__('Advantages'))
                                            ->schema([
                                                TextInput::make('value')
                                                    ->label(__('Value'))
                                                    ->numeric()
                                                    ->rules(['nullable']),
                                                TextInput::make('title')
                                                    ->label(__('Title'))
                                                    ->rules(['nullable', 'max:255']),
                                                TextInput::make('description')
                                                    ->label(__('Description'))
                                                    ->rules(['nullable', 'max:255']),
                                            ])
                                            ->columns(3)
                                            ->itemLabel(fn (array $state): ?string => $state['title'][app()->getLocale()] ?? null)
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(3)
                                            ->maxItems(3),
                                        Repeater::make('advantage_images')
                                            ->label(__('Advantage Images Alt Texts'))
                                            ->schema([
                                                TextInput::make('alt')
                                                    ->label(__('Alt Text'))
                                                    ->rules(['nullable', 'max:255']),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['alt'][app()->getLocale()] ?? null)
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(3)
                                            ->maxItems(3),
                                    ])
                                    ->collapsible(),

                                // About Section
                                Section::make(__('About Section'))
                                    ->schema([
                                        TextInput::make('about_title')
                                            ->label(__('About Title'))
                                            ->rules(['nullable', 'max:255']),
                                        Repeater::make('about_description')
                                            ->label(__('About Description'))
                                            ->schema([
                                                Textarea::make('text')
                                                    ->label(__('Paragraph'))
                                                    ->rules(['nullable']),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => substr($state['text'][app()->getLocale()] ?? '', 0, 50) . '...' ?? null)
                                            ->collapsible()
                                            ->cloneable()
                                    ])
                                    ->collapsible(),

                                // Gallery Section
                                Section::make(__('Gallery Section'))
                                    ->schema([
                                        TextInput::make('gallery_title')
                                            ->label(__('Gallery Title'))
                                            ->rules(['nullable', 'max:255']),
                                        Repeater::make('gallery_images')
                                            ->label(__('Gallery Images Alt Texts'))
                                            ->schema([
                                                TextInput::make('alt')
                                                    ->label(__('Alt Text'))
                                                    ->rules(['nullable', 'max:255']),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['alt'][app()->getLocale()] ?? null)
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(5),
                                    ])
                                    ->collapsible(),

                                // Certificates Section
                                Section::make(__('Certificates Section'))
                                    ->schema([
                                        TextInput::make('certificates_title')
                                            ->label(__('Certificates Title'))
                                            ->rules(['nullable', 'max:255']),
                                        Repeater::make('certificates_images')
                                            ->label(__('Certificates Images Alt Texts'))
                                            ->schema([
                                                TextInput::make('alt')
                                                    ->label(__('Alt Text'))
                                                    ->rules(['nullable', 'max:255']),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['alt'][app()->getLocale()] ?? null)
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(5),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            Log::info('About Us Settings Form Data', ['data' => $data]);

            $settings = app(AboutUsSettings::class);
            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title(__('Налаштування сторінки "Про нас" збережено!'))
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Log::error('Помилки валідації в налаштуваннях сторінки "Про нас"', [
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);

            Notification::make()
                ->title(__('Помилка збереження налаштувань'))
                ->body(implode(', ', array_merge(...array_values($e->errors()))))
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Log::error('Помилка збереження налаштувань сторінки "Про нас"', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title(__('Помилка збереження налаштувань'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
