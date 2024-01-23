<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum ActivationStatus: int
{
    use Options, Values, InvokableCases;

    case PENDING = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('app.general.PENDING'),
            self::ACTIVE => __('app.general.ACTIVE'),
            self::INACTIVE => __('app.general.INACTIVE'),
        };
    }

}
