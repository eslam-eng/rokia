<?php

namespace App\Enums;
enum UsersType: int
{
    case SUPERADMIN = 1;
    case THERAPIST = 2;
    case CLIENT = 3;
    case EMPLOYEE = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
