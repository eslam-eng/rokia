<?php

namespace App\Enums;

enum LecturesTypeEnum: int
{

    case RECORDED = 1;
    case LIVE = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
