<?php

namespace App\Filament\Pages;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

use App\Settings\FooterSettings;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class Footer extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.footer';
    protected static string $settings = FooterSettings::class;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(FooterSettings::class);
        $this->form->fill([
            'phone' => $settings->phone,
            'email' => $settings->email,
            'social_links' => $settings->social_links,
            'address' => $settings->address,
            'copyright_text' => $settings->copyright_text,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone')->label('Телефон')->required(),
                TextInput::make('email')->label('Email')->email()->required(),
                Textarea::make('address')->label('Адреса')->required(),
                TextInput::make('copyright_text')->label('Текст копірайту')->required(),

                Repeater::make('social_links')
                    ->label('Соцмережі')
                    ->schema([
                        TextInput::make('url')->label('Посилання')->url()->required(),
                        TextInput::make('icon_url')->label('URL іконки')->required(),
                    ])
                    ->default([])
                    ->collapsible()
                    ->reorderable(),

                Repeater::make('sections')
                    ->label('Секції меню')
                    ->schema([
                        TextInput::make('title')->label('Заголовок секції')->required(),
                        Repeater::make('links')
                            ->label('Посилання')
                            ->schema([
                                TextInput::make('label')->label('Назва')->required(),
                                TextInput::make('url')->label('URL')->required(),
                            ])
                            ->default([])
                            ->collapsible()
                            ->reorderable(),
                    ])
                    ->default([])
                    ->collapsible()
                    ->reorderable(),
            ])
            ->statePath('data');
    }
    public function save(): void
    {
        $settings = app(FooterSettings::class);
        $settings->fill($this->form->getState());
        $settings->save();


        Notification::make()
            ->title('Дані футера збережено!')
            ->success()
            ->send();
    }
}
