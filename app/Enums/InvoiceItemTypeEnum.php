<?php

namespace App\Enums;


enum InvoiceItemTypeEnum: int
{

    case LECTURE = 1;
    case BOOKAPPOINTMENT = 2;
    case PLANSUBSCRIPTION = 3;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::LECTURE => __('app.invoices.invoice_items.buy_lecture'),
            self::BOOKAPPOINTMENT => __('app.invoices.invoice_items.book_appointment'),
            self::PLANSUBSCRIPTION => __('app.invoices.invoice_items.plan_subscription'),
        };
    }
}
