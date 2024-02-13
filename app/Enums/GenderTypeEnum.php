<?php

namespace App\Enums;


enum GenderTypeEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function getLabel(): string
    {
        return match ($this) {
            self::MALE => __('app.general.MALE'),
            self::FEMALE => __('app.general.FEMALE'),
        };
    }
}
