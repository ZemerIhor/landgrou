<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HomeSettings extends Settings
{
    public array $hero_slides;

    // Banner Section
    public string $hero_heading;
    public string $hero_subheading;
    public ?string $hero_background_image = null;

    // Advantages Section
    public array $advantages_cards;
    public ?string $advantages_image_1 = null;
    public ?string $advantages_image_2 = null;
    public ?string $advantages_image_3 = null;

    // Comparison Section
    public string $comparison_title;
    public ?string $main_comparison_image = null;
    public string $main_comparison_alt;
    public array $comparison_items;
    public string $central_text_value;
    public string $central_text_unit;
    public ?string $comparison_link = null; // Changed to nullable

    // FAQ Section
    public array $faq_items;

    // Feedback Form Section
    public string $feedback_form_title;
    public string $feedback_form_description;
    public ?string $feedback_form_image = null;
    public string $feedback_form_image_alt;

    // Tenders Section
    public string $tenders_title;
    public array $tender_items;
    public string $tenders_phone;
    // About Section
    public string $about_title;
    public string $about_description;
    public ?string $about_more_link = null ;
    public ?string $about_certificates_link = null;
    public string $about_statistic_title;
    public string $about_statistic_description;
    public ?string $about_location_image = null;
    public string $about_location_caption;

    // Reviews Section
    public string $reviews_title;
    public array $review_items;
    public ?string $reviews_more_link = null;

    public static function group(): string
    {
        return 'home';
    }
}
