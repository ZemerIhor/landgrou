<?php

use App\Settings\HomeSettings;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddFaqImagesToHomeSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('home.faq_main_image', null); // Поле для основного изображения FAQ
        $this->migrator->add('home.faq_main_image_alt', ['en' => '', 'uk' => '']); // Поле для альтернативного текста
    }

    public function down(): void
    {
        $this->migrator->delete('home.faq_main_image');
        $this->migrator->delete('home.faq_main_image_alt');
    }
}
