<?php

namespace App\Filament\Pages;

use App\Settings\HomeSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;
use Illuminate\Support\Facades\Log;

class Home extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.home';

    protected static string $settings = HomeSettings::class;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(HomeSettings::class);

        $this->data = [
            'hero_slides' => $settings->hero_slides ?? [],
            'advantages_cards' => $settings->advantages_cards ?? [],
            'advantages_image_1' => $settings->advantages_image_1,
            'advantages_image_2' => $settings->advantages_image_2,
            'advantages_image_3' => $settings->advantages_image_3,
            'comparison_title' => $settings->comparison_title,
            'main_comparison_image' => $settings->main_comparison_image,
            'main_comparison_alt' => $settings->main_comparison_alt,
            'comparison_items' => $settings->comparison_items ?? [],
            'central_text_value' => $settings->central_text_value,
            'central_text_unit' => $settings->central_text_unit,
            'faq_items' => $settings->faq_items ?? [],
            'feedback_form_title' => $settings->feedback_form_title,
            'feedback_form_description' => $settings->feedback_form_description,
            'feedback_form_image' => $settings->feedback_form_image,
            'feedback_form_image_alt' => $settings->feedback_form_image_alt,
            'tenders_title' => $settings->tenders_title,
            'tender_items' => $settings->tender_items ?? [],
            'tenders_phone' => $settings->tenders_phone,
            'about_title' => $settings->about_title,
            'about_description' => $settings->about_description,
            'about_more_link' => $settings->about_more_link,
            'about_certificates_link' => $settings->about_certificates_link,
            'about_statistic_title' => $settings->about_statistic_title,
            'about_statistic_description' => $settings->about_statistic_description,
            'about_location_image' => $settings->about_location_image,
            'about_location_caption' => $settings->about_location_caption,
            'reviews_title' => $settings->reviews_title,
            'review_items' => $settings->review_items ?? [],
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Баннер'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                Repeater::make('hero_slides')
                                    ->label(__('Слайды баннера'))
                                    ->schema([
                                        TextInput::make('heading')
                                            ->label(__('Заголовок'))
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('subheading')
                                            ->label(__('Подзаголовок'))
                                            ->required()
                                            ->maxLength(500),
                                        TextInput::make('extra_text')
                                            ->label(__('Дополнительный текст'))
                                            ->maxLength(255),
                                        FileUpload::make('background_image')
                                            ->label(__('Фоновое изображение'))
                                            ->directory('home/banners')
                                            ->disk('public')
                                            ->preserveFilenames()
                                            ->maxSize(5120)
                                            ->image()
                                            ->required(false),
                                    ])
                                    ->maxItems(5)
                                    ->collapsible()
                                    ->reorderable(),
                            ]),
                    ])
                    ->collapsible(),

                Section::make(__('Преимущества'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                Repeater::make('advantages_cards')
                                    ->label(__('Карточки преимуществ'))
                                    ->schema([
                                        TextInput::make('title')
                                            ->label(__('Заголовок'))
                                            ->required()
                                            ->maxLength(100),
                                        Textarea::make('description')
                                            ->label(__('Описание'))
                                            ->required()
                                            ->maxLength(500),
                                    ])
                                    ->maxItems(4)
                                    ->collapsible()
                                    ->reorderable(),
                            ]),
                        FileUpload::make('advantages_image_1')
                            ->label(__('Изображение 1'))
                            ->directory('home/advantages')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(5120)
                            ->image()
                            ->required(false),
                        FileUpload::make('advantages_image_2')
                            ->label(__('Изображение 2'))
                            ->directory('home/advantages')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(5120)
                            ->image()
                            ->required(false),
                        FileUpload::make('advantages_image_3')
                            ->label(__('Изображение 3'))
                            ->directory('home/advantages')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(5120)
                            ->image()
                            ->required(false),
                    ])
                    ->collapsible(),

                Section::make(__('Сравнение'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('comparison_title')
                                    ->label(__('Заголовок'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('main_comparison_alt')
                                    ->label(__('Альтернативный текст основного изображения'))
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('comparison_items')
                                    ->label(__('Пункты сравнения'))
                                    ->schema([
                                        TextInput::make('value')
                                            ->label(__('Значение'))
                                            ->required()
                                            ->maxLength(50),
                                        TextInput::make('unit')
                                            ->label(__('Единица измерения'))
                                            ->required()
                                            ->maxLength(100),
                                        TextInput::make('alt')
                                            ->label(__('Альтернативный текст изображения'))
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->maxItems(3)
                                    ->collapsible()
                                    ->reorderable(),
                                TextInput::make('central_text_value')
                                    ->label(__('Центральное значение'))
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('central_text_unit')
                                    ->label(__('Центральная единица'))
                                    ->required()
                                    ->maxLength(100),
                            ]),
                        FileUpload::make('main_comparison_image')
                            ->label(__('Основное изображение'))
                            ->directory('home/comparison')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(5120)
                            ->image()
                            ->required(false),
                    ])
                    ->collapsible(),

                Section::make(__('Поширені запитання'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                Repeater::make('faq_items')
                                    ->label(__('Пункти FAQ'))
                                    ->schema([
                                        TextInput::make('question')
                                            ->label(__('Питання'))
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('answer')
                                            ->label(__('Відповідь'))
                                            ->required()
                                            ->maxLength(500),
                                    ])
                                    ->maxItems(10)
                                    ->collapsible()
                                    ->reorderable(),
                            ]),
                    ])
                    ->collapsible(),

                Section::make(__('Форма зворотного зв’язку'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('feedback_form_title')
                                    ->label(__('Заголовок'))
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('feedback_form_description')
                                    ->label(__('Опис'))
                                    ->required()
                                    ->maxLength(500),
                                TextInput::make('feedback_form_image_alt')
                                    ->label(__('Альтернативний текст зображення'))
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        FileUpload::make('feedback_form_image')
                            ->label(__('Зображення'))
                            ->directory('home/feedback')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(5120)
                            ->image()
                            ->required(false),
                    ])
                    ->collapsible(),

                Section::make(__('Тендери'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('tenders_title')
                                    ->label(__('Заголовок'))
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('tender_items')
                                    ->label(__('Пункти тендерів'))
                                    ->schema([
                                        TextInput::make('title')
                                            ->label(__('Назва'))
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->maxItems(5)
                                    ->collapsible()
                                    ->reorderable(),
                                TextInput::make('tenders_phone')
                                    ->label(__('Телефон відділу тендерів'))
                                    ->required()
                                    ->maxLength(20),
                            ]),
                    ])
                    ->collapsible(),

                Section::make(__('Про нас'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('about_title')
                                    ->label(__('Заголовок'))
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('about_description')
                                    ->label(__('Опис'))
                                    ->required()
                                    ->maxLength(1000),
                                TextInput::make('about_more_link')
                                    ->label(__('Посилання "Більше"'))
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('about_certificates_link')
                                    ->label(__('Посилання "Сертифікати"'))
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('about_statistic_title')
                                    ->label(__('Заголовок статистики'))
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('about_statistic_description')
                                    ->label(__('Опис статистики'))
                                    ->required()
                                    ->maxLength(1000),
                                TextInput::make('about_location_caption')
                                    ->label(__('Підпис до зображення локації'))
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        FileUpload::make('about_location_image')
                            ->label(__('Зображення локації'))
                            ->directory('home/about')
                            ->disk('public')
                            ->preserveFilenames()
                            ->maxSize(5120)
                            ->image()
                            ->required(false),
                    ])
                    ->collapsible(),

                Section::make(__('Відгуки'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('reviews_title')
                                    ->label(__('Заголовок'))
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('review_items')
                                    ->label(__('Відгуки'))
                                    ->schema([
                                        TextInput::make('name')
                                            ->label(__('Ім’я'))
                                            ->required()
                                            ->maxLength(100),
                                        TextInput::make('date')
                                            ->label(__('Дата'))
                                            ->type('date')
                                            ->required(),
                                        TextInput::make('rating')
                                            ->label(__('Рейтинг (1-5)'))
                                            ->numeric()
                                            ->required()
                                            ->minValue(1)
                                            ->maxValue(5),
                                        Textarea::make('text')
                                            ->label(__('Текст відгуку'))
                                            ->required()
                                            ->maxLength(500),
                                    ])
                                    ->maxItems(10)
                                    ->collapsible()
                                    ->reorderable(),
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

            // Логирование данных для отладки
            Log::info('Home Settings Form Data', ['data' => $data]);

            // Нормализация данных для FileUpload полей
            $fileFields = [
                'advantages_image_1', 'advantages_image_2', 'advantages_image_3',
                'main_comparison_image', 'feedback_form_image', 'about_location_image',
            ];

            foreach ($fileFields as $field) {
                if (isset($data[$field])) {
                    // Если это массив, берем первый элемент; если строка - оставляем
                    $data[$field] = is_array($data[$field]) ? ($data[$field][0] ?? null) : $data[$field];
                }
            }

            // Нормализация background_image в hero_slides
            if (isset($data['hero_slides']) && is_array($data['hero_slides'])) {
                foreach ($data['hero_slides'] as &$slide) {
                    if (isset($slide['background_image'])) {
                        $slide['background_image'] = is_array($slide['background_image']) ? ($slide['background_image'][0] ?? null) : $slide['background_image'];
                    }
                }
                unset($slide); // Очистка ссылки
            }

            $settings = app(HomeSettings::class);
            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title(__('Дані головної сторінки збережено!'))
                ->success()
                ->send();
        } catch (\Exception $e) {
            Log::error('Error saving Home Settings', ['error' => $e->getMessage()]);
            Notification::make()
                ->title(__('Помилка збереження налаштувань'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
