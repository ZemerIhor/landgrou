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

    // Поля для статических страниц
    public array $home_title;
    public array $home_meta_description;
    public array $about_us_title;
    public array $about_us_meta_description;
    public array $contacts_title;
    public array $contacts_meta_description;
    public array $faq_title;
    public array $faq_meta_description;
    public array $reviews_title;
    public array $reviews_meta_description;
    public array $submit_review_title;
    public array $submit_review_meta_description;
    public array $blog_title;
    public array $blog_meta_description;
    public array $checkout_title;
    public array $checkout_meta_description;
    public array $checkout_success_title;
    public array $checkout_success_meta_description;

    public static function group(): string
    {
        return 'global';
    }
}
