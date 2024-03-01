<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_logo');
        $this->migrator->add('general.about_us');
        $this->migrator->add('general.privacy_condition');
        $this->migrator->add('general.support_phone');
    }
};
