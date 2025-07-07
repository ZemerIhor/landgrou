<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class ContactSettings extends Settings
{
    use HasTranslations;

    // Переводимые поля
    public array $main_address;
    public array $export_contact;
    public array $map_image_alt;

    // Непереводимые поля
    public string $main_email;
    public array $sales_phones;
    public string $sales_email;
    public string $export_phone;
    public string $export_email;
    public array $additional_emails;
    public string $map_image;

    // Публичное свойство для переводимых полей
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
