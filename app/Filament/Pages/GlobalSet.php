<?php

namespace App\Filament\Pages;

use App\Settings\GlobalSettings;
use App\Settings\FooterSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class GlobalSet extends Page implements HasForms
{
    protected static string $settings = GlobalSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Глобальные настройки';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?int $navigationSort = 1;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основные настройки сайта')
                    ->schema([
                        Forms\Components\TextInput::make('site_name.en')
                            ->label('Название сайта (EN)')
                            ->required(),
                        Forms\Components\TextInput::make('site_name.uk')
                            ->label('Название сайта (UA)')
                            ->required(),
                        Forms\Components\Textarea::make('meta_description.en')
                            ->label('Мета-описание (EN)')
                            ->rows(4)
                            ->required(),
                        Forms\Components\Textarea::make('meta_description.uk')
                            ->label('Мета-описание (UA)')
                            ->rows(4)
                            ->required(),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Логотип')
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->nullable(),
                        Forms\Components\FileUpload::make('favicon')
                            ->label('Фавикон')
                            ->image()
                            ->disk('public')
                            ->directory('favicons')
                            ->nullable(),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Контактный email')
                            ->email()
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Форма обратной связи')
                    ->schema([
                        Forms\Components\TextInput::make('feedback_form_title.en')
                            ->label('Заголовок формы (EN)')
                            ->required(),
                        Forms\Components\TextInput::make('feedback_form_title.uk')
                            ->label('Заголовок формы (UA)')
                            ->required(),
                        Forms\Components\Textarea::make('feedback_form_description.en')
                            ->label('Описание формы (EN)')
                            ->rows(4)
                            ->required(),
                        Forms\Components\Textarea::make('feedback_form_description.uk')
                            ->label('Описание формы (UA)')
                            ->rows(4)
                            ->required(),
                        Forms\Components\FileUpload::make('feedback_form_image')
                            ->label('Изображение формы')
                            ->image()
                            ->disk('public')
                            ->directory('feedback-images')
                            ->nullable(),
                        Forms\Components\TextInput::make('feedback_form_image_alt.en')
                            ->label('Alt-текст изображения (EN)')
                            ->nullable(),
                        Forms\Components\TextInput::make('feedback_form_image_alt.uk')
                            ->label('Alt-текст изображения (UA)')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.settings.navigation_label');
    }
}
