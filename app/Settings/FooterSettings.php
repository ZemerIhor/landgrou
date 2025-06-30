<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FooterSettings extends Settings
{
    public array $social_links = [];
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public string $copyright_text = '';

    public static function group(): string
    {
        return 'footer';
    }
}
