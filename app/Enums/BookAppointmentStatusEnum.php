<?php

namespace App\Enums;

enum BookAppointmentStatusEnum: int
{

    case PENDING = 1;
    case WAITING_FOR_PAID = 2;
    case APPROVED = 3;
    case COMPOLETED = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
