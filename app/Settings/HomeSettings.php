<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class HomeSettings extends Settings
{
    use HasTranslations;

    public array $hero_slides = [];

    public ?string $hero_heading = null;
    public ?string $hero_subheading = null;
    public ?string $hero_background_image = null;

    public array $advantages_cards = [];
    public ?string $advantages_image_1 = null;
    public ?string $advantages_image_2 = null;
    public ?string $advantages_image_3 = null;

    // Translatable fields (no strict ?string typehint)
    public $comparison_title;
    public ?string $main_comparison_image = null;
    public $main_comparison_alt;
    public array $comparison_items = [];
    public $central_text_value;
    public $central_text_unit;
    public ?string $comparison_link = null;

    public array $faq_items = [];

    public $feedback_form_title;
    public $feedback_form_description;
    public ?string $feedback_form_image = null;
    public $feedback_form_image_alt;

    public $tenders_title;
    public array $tender_items = [];
    public $tenders_phone;

    public $about_title;
    public $about_description;
    public $about_more_link;
    public $about_certificates_link;
    public $about_statistic_title;
    public $about_statistic_description;
    public ?string $about_location_image = null;
    public $about_location_caption;

    public $reviews_title;
    public array $review_items = [];
    public ?string $reviews_more_link = null;

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
