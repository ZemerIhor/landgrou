<?php

namespace App\Filament\Pages;

use App\Settings\GlobalSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class GlobalSet extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament.pages.global-settings';

    protected static ?string $navigationLabel = 'Global Settings';

    public static function getSlug(): string
    {
        return 'global-settings';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(GlobalSettings::class);

        $this->data = [
            'site_name' => $settings->site_name ?? ['en' => '', 'uk' => ''],
            'meta_description' => $settings->meta_description ?? ['en' => '', 'uk' => ''],
            'logo' => $settings->logo ?? '',
            'favicon' => $settings->favicon ?? '',
            'contact_email' => $settings->contact_email ?? '',
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Global Settings'))
                    ->schema([
                        Translate::make()
                            ->locales(['en', 'uk'])
                            ->schema([
                                TextInput::make('site_name')
                                    ->label(__('Site Name'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('meta_description')
                                    ->label(__('Meta Description'))
                                    ->required()
                                    ->maxLength(500),
                                FileUpload::make('logo')
                                    ->label(__('Site Logo'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('global-images')
                                    ->required(),
                                FileUpload::make('favicon')
                                    ->label(__('Favicon'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('global-images')
                                    ->required(),
                                TextInput::make('contact_email')
                                    ->label(__('Contact Email'))
                                    ->email()
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

            \Illuminate\Support\Facades\Log::info('Global Settings Form Data', ['data' => $data]);

            $settings = app(GlobalSettings::class);
            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title(__('Global settings saved!'))
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving global settings', ['error' => $e->getMessage()]);
            Notification::make()
                ->title(__('Error saving settings'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
