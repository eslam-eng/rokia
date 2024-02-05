<?php

namespace App\Services\Settings;

use App\Models\Settings\GeneralSettings;
use Illuminate\Support\Arr;

class SettingsService
{
    public function __construct(public GeneralSettings $generalSettings)
    {
    }

    public function updateGeneralSettings(array $generalSettingsData): GeneralSettings
    {
        $this->generalSettings->app_logo = Arr::get($generalSettingsData, 'app_logo');
        $this->generalSettings->about_us = Arr::get($generalSettingsData, 'about_us');
        $this->generalSettings->privacy_condition = Arr::get($generalSettingsData, 'privacy_condition');
        $this->generalSettings->support_phone = Arr::get($generalSettingsData, 'support_phone');

        return $this->generalSettings->save();
    }
}
