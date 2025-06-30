<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('home.hero_slides', []);

    }

    public function down(): void
    {
        $this->migrator->delete('home.hero_slides', []);

    }
};
