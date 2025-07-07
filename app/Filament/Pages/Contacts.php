<?php

namespace App\Filament\Pages;

use App\Settings\ContactSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class Contacts extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static string $view = 'filament.pages.contacts';

    protected static ?string $navigationLabel = 'Contact Settings';

    public static function getSlug(): string
    {
        return 'contacts';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(ContactSettings::class);

        $this->data = [
            'main_address' => $settings->main_address ?? ['en' => '', 'uk' => ''],
            'main_email' => $settings->main_email ?? '',
            'sales_phones' => $settings->sales_phones ?? [],
            'sales_email' => $settings->sales_email ?? '',
            'export_phone' => $settings->export_phone ?? '',
            'export_contact' => $settings->export_contact ?? ['en' => '', 'uk' => ''],
            'export_email' => $settings->export_email ?? '',
            'additional_emails' => collect($settings->additional_emails ?? [])->map(function ($value, $key) {
                return ['key' => $key, 'value' => $value];
            })->values()->toArray(),
            'map_image' => $settings->map_image ?? '',
            'map_image_alt' => $settings->map_image_alt ?? ['en' => '', 'uk' => ''],
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('messages.contacts.title'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('main_address')
                                    ->label(__('messages.contacts.address'))
                                    ->required()
                                    ->maxLength(500),
                                TextInput::make('main_email')
                                    ->label(__('messages.contacts.main_email'))
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('sales_phones')
                                    ->label(__('messages.contacts.sales_phones'))
                                    ->schema([
                                        TextInput::make('phone')
                                            ->label(__('messages.contacts.phone'))
                                            ->required()
                                            ->tel()
                                            ->maxLength(20),
                                    ])
                                    ->collapsible()
                                    ->cloneable(),
                                TextInput::make('sales_email')
                                    ->label(__('messages.contacts.sales_email'))
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('export_phone')
                                    ->label(__('messages.contacts.export_phone'))
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('export_contact')
                                    ->label(__('messages.contacts.export_contact'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('export_email')
                                    ->label(__('messages.contacts.export_email'))
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('additional_emails')
                                    ->label(__('messages.contacts.additional_emails'))
                                    ->schema([
                                        TextInput::make('key')
                                            ->label(__('messages.contacts.email_key'))
                                            ->required()
                                            ->maxLength(50),
                                        TextInput::make('value')
                                            ->label(__('messages.contacts.email_value'))
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->collapsible()
                                    ->cloneable(),
                                FileUpload::make('map_image')
                                    ->label(__('messages.contacts.map_image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('contacts-images')
                                    ->required(),
                                TextInput::make('map_image_alt')
                                    ->label(__('messages.contacts.map_alt'))
                                    ->required()
                                    ->maxLength(255),
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

            // Transform additional_emails into an associative array
            $data['additional_emails'] = collect($data['additional_emails'])->pluck('value', 'key')->toArray();

            \Illuminate\Support\Facades\Log::info('Contact Settings Form Data', ['data' => $data]);

            $settings = app(ContactSettings::class);
            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title(__('messages.contacts.saved'))
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving contact settings', ['error' => $e->getMessage()]);
            Notification::make()
                ->title(__('messages.contacts.error'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
