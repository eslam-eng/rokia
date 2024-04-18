<?php

namespace App\Enums;
enum AvailableLanguagesEnum: string
{
    case ARABIC = 'ar';
    case ENGLISH = 'en';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::ARABIC => 'عربي',
            self::ENGLISH =>'English',
        };
    }

}
