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


    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('app.appointments.pending'),
            self::WAITING_FOR_PAID => __('app.appointments.waiting_for_paid'),
            self::APPROVED => __('app.appointments.approved'),
            self::COMPOLETED => __('app.appointments.compeleted'),
        };
    }

    public function getClasses(): string
    {
        return match ($this) {
            self::PENDING =>'badge-danger',
            self::WAITING_FOR_PAID => 'badge-warning',
            self::APPROVED,self::COMPOLETED => 'badge-success',
        };
    }

}