<?php

namespace App\Models\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public mixed $app_logo = null;
    public ?string $about_us = null;

    public ?string $privacy_condition = null;
    public ?string $support_phone = null;

    public static function group(): string
    {
        return 'general';
    }
}
