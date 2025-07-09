<?php

namespace App\Filament\Pages;

use App\Settings\GlobalSettings;
use Filament\Forms\Components\Section;
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
    protected static ?string $navigationLabel = 'Глобальные настройки';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.global-setting';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(GlobalSettings::class);

        // Инициализация данных формы из настроек
        $this->data = [
            'site_name' => $settings->site_name ?? ['en' => '', 'uk' => ''],
            'meta_description' => $settings->meta_description ?? ['en' => '', 'uk' => ''],
            'logo' => $settings->logo ?? '',
            'favicon' => $settings->favicon ?? '',
            'contact_email' => $settings->contact_email ?? '',
            'feedback_form_title' => $settings->feedback_form_title ?? ['en' => '', 'uk' => ''],
            'feedback_form_description' => $settings->feedback_form_description ?? ['en' => '', 'uk' => ''],
            'feedback_form_image' => $settings->feedback_form_image ?? '',
            'feedback_form_image_alt' => $settings->feedback_form_image_alt ?? ['en' => '', 'uk' => ''],
        ];

        Log::info('Global Settings form initialized', ['data' => $this->data]);

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('messages.settings.main_section'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('site_name')
                                    ->label(__('messages.settings.site_name'))
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->label(__('messages.settings.meta_description'))
                                    ->rows(4)
                                    ->required()
                                    ->maxLength(500),
                            ]),
                        FileUpload::make('logo')
                            ->label(__('messages.settings.logo'))
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->nullable()
                            ->rules(['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp']),
                        FileUpload::make('favicon')
                            ->label(__('messages.settings.favicon'))
                            ->image()
                            ->disk('public')
                            ->directory('favicons')
                            ->nullable()
                            ->rules(['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp']),
                        TextInput::make('contact_email')
                            ->label(__('messages.settings.contact_email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->collapsible()
                    ->columns(2),

                Section::make(__('messages.settings.feedback_form_section'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('feedback_form_title')
                                    ->label(__('messages.settings.feedback_form_title'))
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('feedback_form_description')
                                    ->label(__('messages.settings.feedback_form_description'))
                                    ->rows(4)
                                    ->required()
                                    ->maxLength(500),
                                TextInput::make('feedback_form_image_alt')
                                    ->label(__('messages.settings.feedback_form_image_alt'))
                                    ->nullable()
                                    ->maxLength(255),
                            ]),
                        FileUpload::make('feedback_form_image')
                            ->label(__('messages.settings toller.feedback_form_image'))
                            ->image()
                            ->disk('public')
                            ->directory('feedback-images')
                            ->nullable()
                            ->rules(['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp']),
                    ])
                    ->collapsible()
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Логирование MIME-типа для изображений
            if (isset($data['logo']) && is_object($data['logo'])) {
                Log::info('MIME type for logo', ['mime' => $data['logo']->getMimeType()]);
            }
            if (isset($data['favicon']) && is_object($data['favicon'])) {
                Log::info('MIME type for favicon', ['mime' => $data['favicon']->getMimeType()]);
            }
            if (isset($data['feedback_form_image']) && is_object($data['feedback_form_image'])) {
                Log::info('MIME type for feedback_form_image', ['mime' => $data['feedback_form_image']->getMimeType()]);
            }

            Log::info('Global Settings Form Data', ['data' => $data]);

            $settings = app(GlobalSettings::class);
            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title(__('messages.settings.saved'))
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Log::error('Ошибки валидации в глобальных настройках', [
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);

            Notification::make()
                ->title(__('messages.settings.error'))
                ->body(implode(', ', array_merge(...array_values($e->errors()))))
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Log::error('Ошибка сохранения глобальных настроек', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title(__('messages.settings.error'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.settings.navigation_label');
    }

    public static function getSlug(): string
    {
        return 'global-settings';
    }
}
