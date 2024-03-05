<?php

namespace App\Enums;
enum ClientPlanStatusEnum: int
{
    case PENDING = 0;
    case RUNNING = 1;
    case FINSHED = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
