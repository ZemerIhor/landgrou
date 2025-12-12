<?php

namespace App\Filament\Pages;

use App\Settings\GlobalSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class GlobalSet extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $settings = GlobalSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Global Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.global-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(GlobalSettings::class);

        // Initialize form data with en/uk translations
        $this->data = [
            'site_name' => $settings->site_name ?? ['en' => 'My Website', 'uk' => 'Мій сайт'],
            'meta_description' => $settings->meta_description ?? ['en' => 'Welcome to my website', 'uk' => 'Ласкаво просимо на мій сайт'],
            'logo' => $settings->logo ?? '',
            'favicon' => $settings->favicon ?? '',
            'contact_email' => $settings->contact_email ?? 'contact@example.com',
            'feedback_form_title' => $settings->feedback_form_title ?? ['en' => 'Feedback Form', 'uk' => 'Форма зворотного зв’язку'],
            'feedback_form_description' => $settings->feedback_form_description ?? ['en' => 'Please leave your feedback', 'uk' => 'Будь ласка, залиште ваш відгук'],
            'feedback_form_image' => $settings->feedback_form_image ?? '',
            'home_title' => $settings->home_title ?? ['en' => 'Home Page', 'uk' => 'Головна сторінка'],
            'home_meta_description' => $settings->home_meta_description ?? ['en' => 'Welcome to the home page of our website', 'uk' => 'Ласкаво просимо на головну сторінку нашого сайту'],
            'about_us_title' => $settings->about_us_title ?? ['en' => 'About Us', 'uk' => 'Про нас'],
            'about_us_meta_description' => $settings->about_us_meta_description ?? ['en' => 'Learn more about our company', 'uk' => 'Дізнайтесь більше про нашу компанію'],
            'contacts_title' => $settings->contacts_title ?? ['en' => 'Contacts', 'uk' => 'Контакти'],
            'contacts_meta_description' => $settings->contacts_meta_description ?? ['en' => 'Get in touch with us', 'uk' => 'Зв’яжіться з нами'],
            'faq_title' => $settings->faq_title ?? ['en' => 'FAQ', 'uk' => 'Питання та відповіді'],
            'faq_meta_description' => $settings->faq_meta_description ?? ['en' => 'Answers to frequently asked questions', 'uk' => 'Відповіді на поширені запитання'],
            'reviews_title' => $settings->reviews_title ?? ['en' => 'Reviews', 'uk' => 'Відгуки'],
            'reviews_meta_description' => $settings->reviews_meta_description ?? ['en' => 'Read our customer reviews', 'uk' => 'Читайте відгуки наших клієнтів'],
            'submit_review_title' => $settings->submit_review_title ?? ['en' => 'Submit Review', 'uk' => 'Додати відгук'],
            'submit_review_meta_description' => $settings->submit_review_meta_description ?? ['en' => 'Share your feedback about our products', 'uk' => 'Поділіться своїм відгуком про наші товари'],
            'blog_title' => $settings->blog_title ?? ['en' => 'Blog', 'uk' => 'Блог'],
            'blog_meta_description' => $settings->blog_meta_description ?? ['en' => 'Read our latest articles and news', 'uk' => 'Читайте наші останні статті та новини'],
            'checkout_title' => $settings->checkout_title ?? ['en' => 'Checkout', 'uk' => 'Оформлення замовлення'],
            'checkout_meta_description' => $settings->checkout_meta_description ?? ['en' => 'Complete your order quickly and easily', 'uk' => 'Оформіть своє замовлення швидко та легко'],
            'checkout_success_title' => $settings->checkout_success_title ?? ['en' => 'Order Successfully Placed', 'uk' => 'Замовлення успішно оформлено'],
            'checkout_success_meta_description' => $settings->checkout_success_meta_description ?? ['en' => 'Thank you for your order!', 'uk' => 'Дякуємо за ваше замовлення!'],
        ];

        Log::info('Global Settings form initialized', ['data' => $this->data]);

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Main Settings')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Translate::make()
                                            ->locales(['en', 'uk'])
                                            ->schema([
                                                TextInput::make('site_name')
                                                    ->label('Site Name')
                                                    ->helperText('Enter the name of your website')
                                                    ->required()
                                                    ->maxLength(255),
                                                Textarea::make('meta_description')
                                                    ->label('Meta Description')
                                                    ->helperText('Enter the meta description for SEO')
                                                    ->rows(4)
                                                    ->required()
                                                    ->maxLength(500),
                                            ]),
                                        FileUpload::make('logo')
                                            ->label('Logo')
                                            ->helperText('Upload the main site logo')
                                            ->image()
                                            ->disk('public')
                                            ->directory('logos')
                                            ->nullable(),
                                        FileUpload::make('favicon')
                                            ->label('Favicon')
                                            ->helperText('Upload the site favicon')
                                            ->image()
                                            ->disk('public')
                                            ->directory('favicons')
                                            ->nullable(),
                                        TextInput::make('contact_email')
                                            ->label('Contact Email')
                                            ->helperText('Email address for contact inquiries')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),
                            ]),

                        Tabs\Tab::make('Feedback Form')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Translate::make()
                                            ->locales(['en', 'uk'])
                                            ->schema([
                                                TextInput::make('feedback_form_title')
                                                    ->label('Feedback Form Title')
                                                    ->helperText('Title displayed above the feedback form')
                                                    ->required()
                                                    ->maxLength(255),
                                                Textarea::make('feedback_form_description')
                                                    ->label('Feedback Form Description')
                                                    ->helperText('Short description for the feedback form')
                                                    ->rows(4)
                                                    ->required()
                                                    ->maxLength(500),
                                            ]),
                                        FileUpload::make('feedback_form_image')
                                            ->label('Feedback Form Image')
                                            ->helperText('Optional image for the feedback form')
                                            ->image()
                                            ->disk('public')
                                            ->directory('feedback-images')
                                            ->nullable(),
                                    ])
                                    ->columns(2),
                            ]),

                        Tabs\Tab::make('Static Pages')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Translate::make()
                                            ->locales(['en', 'uk'])
                                            ->schema([
                                                TextInput::make('home_title')->label('Home Page Title')->required()->maxLength(255),
                                                Textarea::make('home_meta_description')->label('Home Page Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('about_us_title')->label('About Us Title')->required()->maxLength(255),
                                                Textarea::make('about_us_meta_description')->label('About Us Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('contacts_title')->label('Contacts Page Title')->required()->maxLength(255),
                                                Textarea::make('contacts_meta_description')->label('Contacts Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('faq_title')->label('FAQ Page Title')->required()->maxLength(255),
                                                Textarea::make('faq_meta_description')->label('FAQ Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('reviews_title')->label('Reviews Page Title')->required()->maxLength(255),
                                                Textarea::make('reviews_meta_description')->label('Reviews Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('submit_review_title')->label('Submit Review Title')->required()->maxLength(255),
                                                Textarea::make('submit_review_meta_description')->label('Submit Review Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('blog_title')->label('Blog Page Title')->required()->maxLength(255),
                                                Textarea::make('blog_meta_description')->label('Blog Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('checkout_title')->label('Checkout Page Title')->required()->maxLength(255),
                                                Textarea::make('checkout_meta_description')->label('Checkout Meta Description')->rows(4)->required()->maxLength(500),
                                                TextInput::make('checkout_success_title')->label('Checkout Success Title')->required()->maxLength(255),
                                                Textarea::make('checkout_success_meta_description')->label('Checkout Success Meta Description')->rows(4)->required()->maxLength(500),
                                            ]),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            foreach (['logo', 'favicon', 'feedback_form_image'] as $field) {
                if (isset($data[$field]) && is_object($data[$field])) {
                    Log::info("MIME type for {$field}", ['mime' => $data[$field]->getMimeType()]);
                }
            }

            Log::info('Global Settings Form Data', ['data' => $data]);

            $settings = app(GlobalSettings::class);
            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title('Settings saved')
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Log::error('Validation errors', ['errors' => $e->errors(), 'message' => $e->getMessage()]);

            Notification::make()
                ->title('Error')
                ->body(implode(', ', array_merge(...array_values($e->errors()))))
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Log::error('Error saving settings', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function getNavigationLabel(): string
    {
        return 'Global Settings';
    }

    public static function getSlug(): string
    {
        return 'global-settings';
    }
}
