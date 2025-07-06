<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GlobalSettings extends Settings
{
    public array $site_name;
    public array $meta_description;
    public string $logo;
    public string $favicon;
    public string $contact_email;
    public array $feedback_form_title;
    public array $feedback_form_description;
    public string $feedback_form_image;
    public array $feedback_form_image_alt;

    public static function group(): string
    {
        return 'global';
    }
}
