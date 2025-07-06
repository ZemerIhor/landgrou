<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class ContactSettings extends Settings
{
    use HasTranslations;

    public $main_address;
    public string $main_email;
    public array $sales_phones;
    public string $sales_email;
    public string $export_phone;
    public $export_contact;
    public string $export_email;
    public array $additional_emails;
    public string $map_image;
    public $map_image_alt;

    public array $translatable = [
        'main_address',
        'export_contact',
        'map_image_alt',
    ];

    public static function group(): string
    {
        return 'contacts';
    }
}
