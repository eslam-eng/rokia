<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case FREE = 0;
    case PAID = 1;
    case NOTPAID = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::FREE => __('app.lectures.free'),
            self::PAID =>  __('app.lectures.paid') ,
            self::NOTPAID =>  __('app.lectures.paid') ,
        };
    }
}
