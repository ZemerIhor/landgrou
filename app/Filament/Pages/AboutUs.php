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

    protected static ?string $navigationLabel = 'Налаштування сторінки "Про нас"';

    public static function getSlug(): string
    {
        return 'about-us';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(AboutUsSettings::class);
        $defaultLocale = 'uk';

        // Логируем настройки для отладки
        Log::info('AboutUs Settings', (array) $settings);

        $data = [
            'hero_background_image' => $settings->hero_background_image ?? '',
            'hero_background_image_alt' => is_array($settings->hero_background_image_alt)
                ? ($settings->hero_background_image_alt[app()->getLocale()] ?? $settings->hero_background_image_alt[$defaultLocale] ?? '')
                : ($settings->hero_background_image_alt ?? ''),
            'hero_logo' => $settings->hero_logo ?? '',
            'hero_logo_alt' => is_array($settings->hero_logo_alt)
                ? ($settings->hero_logo_alt[app()->getLocale()] ?? $settings->hero_logo_alt[$defaultLocale] ?? '')
                : ($settings->hero_logo_alt ?? ''),
            'hero_title' => is_array($settings->hero_title)
                ? $settings->hero_title
                : [app()->getLocale() => $settings->hero_title ?? ''],
            'hero_subtitle' => is_array($settings->hero_subtitle)
                ? $settings->hero_subtitle
                : [app()->getLocale() => $settings->hero_subtitle ?? ''],
            'hero_subtitle_highlight' => is_array($settings->hero_subtitle_highlight)
                ? $settings->hero_subtitle_highlight
                : [app()->getLocale() => $settings->hero_subtitle_highlight ?? ''],
            'hero_slogan' => is_array($settings->hero_slogan)
                ? $settings->hero_slogan
                : [app()->getLocale() => $settings->hero_slogan ?? ''],
            'hero_description' => is_array($settings->hero_description)
                ? $settings->hero_description
                : [app()->getLocale() => $settings->hero_description ?? ''],
            'advantages' => is_array($settings->advantages)
                ? $settings->advantages
                : [app()->getLocale() => $settings->advantages ?? []],
            'advantage_images' => array_map(function ($item) use ($defaultLocale) {
                return [
                    'image' => $item['image'] ?? '',
                    'alt' => is_array($item['alt']) ? ($item['alt'][app()->getLocale()] ?? $item['alt'][$defaultLocale] ?? '') : ($item['alt'] ?? ''),
                ];
            }, $settings->advantage_images ?? []),
            'about_title' => is_array($settings->about_title)
                ? $settings->about_title
                : [app()->getLocale() => $settings->about_title ?? ''],
            'about_description' => is_array($settings->about_description)
                ? $settings->about_description
                : [app()->getLocale() => $settings->about_description ?? []],
            'gallery_title' => is_array($settings->gallery_title)
                ? $settings->gallery_title
                : [app()->getLocale() => $settings->gallery_title ?? ''],
            'gallery_images' => array_map(function ($item) use ($defaultLocale) {
                return [
                    'image' => $item['image'] ?? '',
                    'alt' => is_array($item['alt']) ? ($item['alt'][app()->getLocale()] ?? $item['alt'][$defaultLocale] ?? '') : ($item['alt'] ?? ''),
                ];
            }, $settings->gallery_images ?? []),
            'certificates_title' => is_array($settings->certificates_title)
                ? $settings->certificates_title
                : [app()->getLocale() => $settings->certificates_title ?? ''],
            'certificates_images' => array_map(function ($item) use ($defaultLocale) {
                return [
                    'image' => $item['image'] ?? '',
                    'alt' => is_array($item['alt']) ? ($item['alt'][app()->getLocale()] ?? $item['alt'][$defaultLocale] ?? '') : ($item['alt'] ?? ''),
                ];
            }, $settings->certificates_images ?? []),
        ];

        $this->data = $data;
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Налаштування сторінки "Про нас"')
                    ->schema([
                        // Hero Section (Images and Text)
                        Section::make('Геройська секція')
                            ->schema([
                                FileUpload::make('hero_background_image')
                                    ->label('Фонове зображення героя')
                                    ->image()
                                    ->disk('public')
                                    ->directory('about-us/hero'),
                                TextInput::make('hero_background_image_alt')
                                    ->label('Альтернативний текст фонового зображення героя')
                                    ->rules(['nullable', 'string', 'max:255']),
                                FileUpload::make('hero_logo')
                                    ->label('Логотип героя')
                                    ->image()
                                    ->disk('public')
                                    ->directory('about-us/logo'),
                                TextInput::make('hero_logo_alt')
                                    ->label('Альтернативний текст логотипу героя')
                                    ->rules(['nullable', 'string', 'max:255']),
                                Translate::make()
                                    ->locales(['uk'])
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Заголовок героя')
                                            ->rules(['nullable', 'max:255']),
                                        TextInput::make('hero_subtitle')
                                            ->label('Підзаголовок героя')
                                            ->rules(['nullable', 'max:255']),
                                        TextInput::make('hero_subtitle_highlight')
                                            ->label('Виділений підзаголовок героя')
                                            ->rules(['nullable', 'max:100']),
                                        TextInput::make('hero_slogan')
                                            ->label('Слоган героя')
                                            ->rules(['nullable', 'max:100']),
                                        Textarea::make('hero_description')
                                            ->label('Опис героя')
                                            ->rules(['nullable']),
                                    ]),
                            ])
                            ->collapsible(),

                        // Advantages Section
                        Section::make('Переваги')
                            ->schema([
                                Repeater::make('advantage_images')
                                    ->label('Зображення переваг')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Зображення')
                                            ->image()
                                            ->disk('public')
                                            ->directory('about-us/advantages'),
                                        TextInput::make('alt')
                                            ->label('Альтернативний текст')
                                            ->rules(['nullable', 'string', 'max:255']),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => is_string($state['alt']) ? $state['alt'] : null)
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(3)
                                    ->maxItems(3),
                                Translate::make()
                                    ->locales(['uk'])
                                    ->schema([
                                        Repeater::make('advantages')
                                            ->label('Переваги')
                                            ->schema([
                                                TextInput::make('value')
                                                    ->label('Значення')
                                                    ->numeric()
                                                    ->rules(['nullable']),
                                                TextInput::make('title')
                                                    ->label('Заголовок')
                                                    ->rules(['nullable', 'max:255']),
                                                TextInput::make('description')
                                                    ->label('Опис')
                                                    ->rules(['nullable', 'max:255']),
                                            ])
                                            ->columns(3)
                                            ->itemLabel(fn (array $state): ?string => is_array($state['title']) ? ($state['title'][app()->getLocale()] ?? null) : ($state['title'] ?? null))
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(3)
                                            ->maxItems(3),
                                    ]),
                            ])
                            ->collapsible(),

                        // About Section
                        Section::make('Про нас')
                            ->schema([
                                Translate::make()
                                    ->locales(['uk'])
                                    ->schema([
                                        TextInput::make('about_title')
                                            ->label('Заголовок розділу "Про нас"')
                                            ->rules(['nullable', 'max:255']),
                                        Repeater::make('about_description')
                                            ->label('Опис розділу "Про нас"')
                                            ->schema([
                                                Textarea::make('text')
                                                    ->label('Параграф')
                                                    ->rules(['nullable']),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => is_array($state['text']) ? (substr($state['text'][app()->getLocale()] ?? '', 0, 50) . '...' ?? null) : (substr($state['text'] ?? '', 0, 50) . '...' ?? null))
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(1)
                                            ->maxItems(5),
                                    ]),
                            ])
                            ->collapsible(),

                        // Gallery Section
                        Section::make('Галерея')
                            ->schema([
                                Repeater::make('gallery_images')
                                    ->label('Зображення галереї')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Зображення')
                                            ->image()
                                            ->disk('public')
                                            ->directory('about-us/gallery'),
                                        TextInput::make('alt')
                                            ->label('Альтернативний текст')
                                            ->rules(['nullable', 'string', 'max:255']),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => is_string($state['alt']) ? $state['alt'] : null)
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(5),
                                Translate::make()
                                    ->locales(['uk'])
                                    ->schema([
                                        TextInput::make('gallery_title')
                                            ->label('Заголовок галереї')
                                            ->rules(['nullable', 'max:255']),
                                    ]),
                            ])
                            ->collapsible(),

                        // Certificates Section
                        Section::make('Сертифікати')
                            ->schema([
                                Repeater::make('certificates_images')
                                    ->label('Зображення сертифікатів')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Зображення')
                                            ->image()
                                            ->disk('public')
                                            ->directory('about-us/certificates'),
                                        TextInput::make('alt')
                                            ->label('Альтернативний текст')
                                            ->rules(['nullable', 'string', 'max:255']),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => is_string($state['alt']) ? $state['alt'] : null)
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(5),
                                Translate::make()
                                    ->locales(['uk'])
                                    ->schema([
                                        TextInput::make('certificates_title')
                                            ->label('Заголовок сертифікатів')
                                            ->rules(['nullable', 'max:255']),
                                    ]),
                            ])
                            ->collapsible(),
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
                ->title('Налаштування збережено')
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Log::error('Validation errors in About Us settings', [
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);

            Notification::make()
                ->title('Помилка збереження налаштувань')
                ->body(implode(', ', array_merge(...array_values($e->errors()))))
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Log::error('Error saving About Us settings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title('Помилка збереження налаштувань')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
