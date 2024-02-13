<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum WeekDaysEnum: int
{
    use Options, Values, InvokableCases;

    case SUNDAY = 0;
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDDAY = 5;
    case SATURDAY = 6;


    public function getLabel()
    {
        return match ($this) {
            self::SUNDAY => __('app.week_days.SUNDAY'),
            self::MONDAY => __('app.week_days.MONDAY'),
            self::TUESDAY => __('app.week_days.TUESDAY'),
            self::WEDNESDAY => __('app.week_days.WEDNESDAY'),
            self::THURSDAY => __('app.week_days.THURSDAY'),
            self::FRIDDAY => __('app.week_days.FRIDDAY'),
            self::SATURDAY => __('app.week_days.SATURDAY'),
        };
    }
}
