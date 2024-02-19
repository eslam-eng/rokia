<?php

namespace App\Enums;
enum ActivationStatus: int
{
    case PENDING = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('app.general.PENDING'),
            self::ACTIVE => __('app.general.ACTIVE'),
            self::INACTIVE => __('app.general.INACTIVE'),
        };
    }

    public function getClasses(): string
    {
        return match ($this) {
            self::PENDING, self::INACTIVE =>'badge-danger',
            self::ACTIVE => 'badge-success',
        };
    }

}
