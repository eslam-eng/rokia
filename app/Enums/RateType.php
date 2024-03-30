<?php

namespace App\Enums;

enum RateType: string
{
    case LECTURE = 'lecture';
    case THERAPIST = 'therapist';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
