<?php

namespace App\Models\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public mixed $app_logo;
    public string $about_us;

    public string $privacy;



    public int $invoice_printing_count;

    public static function group(): string
    {
        return 'general';
    }
}
