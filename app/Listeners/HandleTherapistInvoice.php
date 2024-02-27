<?php

namespace App\Listeners;

use App\Enums\InvoiceStatusEnum;
use App\Interfaces\TherapistInvoiceInterface;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Therapist;

class HandleTherapistInvoice
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TherapistInvoiceInterface $event): void
    {
        $model = $event->model;
        $therapist = Therapist::query()->find($model->therapist_id);
        //first check if therapist has pending invoice
        $invoice = Invoice::query()->firstOrCreate([
            'therapist_id' => $model->therapist_id,
            'status' => InvoiceStatusEnum::PENDING->value
        ], [
            'sub_total' => 0,
            'grand_total' => 0,
            'therapist_due' => 0,
        ]);

        $invoiceItem = InvoiceItem::query()->create(
            [
                'invoice_id' => $invoice->id,
                'type' => $event->getType(),
                'details' => $event->getDetails(),
                'client_id' => $model->client_id,
                'price' => $event->getPrice(),
                'therapist_commission' => $therapist->therapist_commission,
            ]
        );

        $invoice->update(
            [
                'sub_total' => $invoice->sub_total + $invoiceItem->price,
                'grand_total' => $invoice->sub_total + $invoiceItem->price,
                'therapist_due' => getPriceAfterCommition(price: $invoiceItem->price, commission: $invoiceItem->therapist_commission) + $invoice->therapist_due,
            ]
        );

    }
}
