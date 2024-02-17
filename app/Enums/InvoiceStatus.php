<?php

namespace App\Enums;


enum InvoiceStatus: int
{

    case PENDING = 1;
    case COMPLETED = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
