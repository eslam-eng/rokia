<?php

namespace App\Enums;


enum GenderTypeEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::MALE => __('app.general.MALE'),
            self::FEMALE => __('app.general.FEMALE'),
        };
    }
}
