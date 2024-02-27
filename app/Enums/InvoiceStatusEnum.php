<?php

namespace App\Enums;


enum InvoiceStatusEnum: int
{

    case PENDING = 1;
    case COMPLETED = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('app.invoices.PENDING'),
            self::COMPLETED => __('app.invoices.Completed'),
        };
    }
}
