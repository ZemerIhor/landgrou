<?php

namespace Tests\Unit\Helpers;

use App\Helpers\LocalizationHelper;
use Tests\TestCase;

class LocalizationHelperTest extends TestCase
{
    public function test_get_supported_locales_returns_correct_array()
    {
        $expected = ['en', 'uk'];
        $this->assertEquals($expected, LocalizationHelper::getSupportedLocales());
    }

    public function test_is_supported_returns_true_for_valid_locales()
    {
        $this->assertTrue(LocalizationHelper::isSupported('en'));
        $this->assertTrue(LocalizationHelper::isSupported('uk'));
    }

    public function test_is_supported_returns_false_for_invalid_locales()
    {
        $this->assertFalse(LocalizationHelper::isSupported('fr'));
        $this->assertFalse(LocalizationHelper::isSupported('de'));
        $this->assertFalse(LocalizationHelper::isSupported(''));
        $this->assertFalse(LocalizationHelper::isSupported('invalid'));
    }

    public function test_get_locale_name_returns_correct_names()
    {
        $this->assertEquals('English', LocalizationHelper::getLocaleName('en'));
        $this->assertEquals('Polski', LocalizationHelper::getLocaleName('uk'));
        $this->assertEquals('unknown', LocalizationHelper::getLocaleName('unknown'));
    }

    public function test_get_locale_flag_returns_correct_flags()
    {
        $this->assertEquals('🇺🇸', LocalizationHelper::getLocaleFlag('en'));
        $this->assertEquals('🇵🇱', LocalizationHelper::getLocaleFlag('uk'));
        $this->assertEquals('🌐', LocalizationHelper::getLocaleFlag('unknown'));
    }

    public function test_get_text_direction_returns_ltr()
    {
        $this->assertEquals('ltr', LocalizationHelper::getTextDirection('en'));
        $this->assertEquals('ltr', LocalizationHelper::getTextDirection('uk'));
        $this->assertEquals('ltr', LocalizationHelper::getTextDirection('unknown'));
    }

    public function test_get_translated_value_returns_correct_translation()
    {
        $jsonField = [
            'en' => 'Hello World',
            'uk' => 'Witaj Świecie',
        ];

        $this->assertEquals('Hello World', LocalizationHelper::getTranslatedValue($jsonField, 'en'));
        $this->assertEquals('Witaj Świecie', LocalizationHelper::getTranslatedValue($jsonField, 'uk'));
    }

    public function test_get_translated_value_falls_back_to_default_locale()
    {
        $jsonField = [
            'en' => 'Hello World',
        ];

        // When requesting 'uk' but only 'en' exists, should fallback to 'en'
        $this->assertEquals('Hello World', LocalizationHelper::getTranslatedValue($jsonField, 'uk', 'en'));
    }

    public function test_get_translated_value_returns_first_available_if_no_fallback()
    {
        $jsonField = [
            'fr' => 'Bonjour le monde',
            'de' => 'Hallo Welt',
        ];

        // When neither current nor fallback locale exists, return first available
        $result = LocalizationHelper::getTranslatedValue($jsonField, 'uk', 'en');
        $this->assertEquals('Bonjour le monde', $result);
    }

    public function test_get_translated_value_handles_string_input()
    {
        $stringValue = 'Simple string';

        $this->assertEquals('Simple string', LocalizationHelper::getTranslatedValue($stringValue));
    }

    public function test_create_translatable_array_creates_correct_structure()
    {
        $expected = [
            'en' => 'Test value',
            'uk' => 'Test value',
        ];

        $result = LocalizationHelper::createTranslatableArray('Test value');
        $this->assertEquals($expected, $result);
    }

    public function test_create_translatable_array_with_custom_locales()
    {
        $expected = [
            'en' => 'Test value',
            'fr' => 'Test value',
        ];

        $result = LocalizationHelper::createTranslatableArray('Test value', ['en', 'fr']);
        $this->assertEquals($expected, $result);
    }

    public function test_is_translatable_field_filled_returns_true_for_filled_field()
    {
        $jsonField = [
            'en' => 'Content here',
            'uk' => 'Treść tutaj',
        ];

        $this->assertTrue(LocalizationHelper::isTranslatableFieldFilled($jsonField, 'en'));
        $this->assertTrue(LocalizationHelper::isTranslatableFieldFilled($jsonField, 'uk'));
    }

    public function test_is_translatable_field_filled_returns_false_for_empty_field()
    {
        $jsonField = [
            'en' => '',
            'uk' => '   ', // Only whitespace
        ];

        $this->assertFalse(LocalizationHelper::isTranslatableFieldFilled($jsonField, 'en'));
        $this->assertFalse(LocalizationHelper::isTranslatableFieldFilled($jsonField, 'uk'));
    }

    public function test_get_translation_completeness_calculates_correctly()
    {
        $translatableFields = [
            ['en' => 'Title 1', 'uk' => 'Tytuł 1'],
            ['en' => 'Title 2', 'uk' => ''],
            ['en' => '', 'uk' => 'Tytuł 3'],
        ];

        $result = LocalizationHelper::getTranslationCompleteness($translatableFields);

        $this->assertEquals(2, $result['en']['filled']);
        $this->assertEquals(3, $result['en']['total']);
        $this->assertEquals(66.7, $result['en']['percentage']);

        $this->assertEquals(2, $result['uk']['filled']);
        $this->assertEquals(3, $result['uk']['total']);
        $this->assertEquals(66.7, $result['uk']['percentage']);
    }

    public function test_get_current_locale_metadata_returns_correct_structure()
    {
        app()->setLocale('en');

        $result = LocalizationHelper::getCurrentLocaleMetadata();

        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('flag', $result);
        $this->assertArrayHasKey('direction', $result);
        $this->assertArrayHasKey('is_default', $result);

        $this->assertEquals('en', $result['code']);
        $this->assertEquals('English', $result['name']);
        $this->assertEquals('🇺🇸', $result['flag']);
        $this->assertEquals('ltr', $result['direction']);
    }
}
