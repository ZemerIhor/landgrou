<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class HomeSettings extends Settings
{
    use HasTranslations;

    public array $hero_slides;
    public array $advantages_cards;
    public ?string $advantages_image_1;
    public ?string $advantages_image_2;
    public ?string $advantages_image_3;
    public array $comparison_title;
    public ?string $main_comparison_image;
    public array $main_comparison_alt;
    public array $comparison_items;
    public array $central_text_value;
    public array $central_text_unit;
    public array $faq_items;
    public array $feedback_form_title;
    public array $feedback_form_description;
    public ?string $feedback_form_image;
    public array $feedback_form_image_alt;
    public array $tenders_title;
    public array $tender_items;
    public array $tenders_phone;
    public array $about_title;
    public array $about_description;
    public array $about_more_link;
    public array $about_certificates_link;
    public array $about_statistic_title;
    public array $about_statistic_description;
    public ?string $about_location_image;
    public array $about_location_caption;
    public array $reviews_title;
    public array $review_items;

    protected array $translatable = [
        'hero_slides',
        'advantages_cards',
        'comparison_title',
        'main_comparison_alt',
        'comparison_items',
        'central_text_value',
        'central_text_unit',
        'faq_items',
        'feedback_form_title',
        'feedback_form_description',
        'feedback_form_image_alt',
        'tenders_title',
        'tender_items',
        'tenders_phone',
        'about_title',
        'about_description',
        'about_more_link',
        'about_certificates_link',
        'about_statistic_title',
        'about_statistic_description',
        'about_location_caption',
        'reviews_title',
        'review_items',
    ];

    public static function group(): string
    {
        return 'home';
    }
}
