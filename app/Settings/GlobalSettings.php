<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GlobalSettings extends Settings
{
    public  $site_name;
    public  $meta_description;
    public  $logo;
    public  $favicon;
    public  $contact_email;
    public  $feedback_form_title;
    public  $feedback_form_description;
    public  $feedback_form_image;
    public  $feedback_form_image_alt;

    public static function group(): string
    {
        return 'global';
    }
}
