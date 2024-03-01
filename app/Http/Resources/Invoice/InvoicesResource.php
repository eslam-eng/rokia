<?php

namespace App\Http\Resources\Invoice;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'therapist_due' => $this->therapist_due,
            'status'=>InvoiceStatusEnum::from($this->status)->getLabel(),
            'invoice_items_count'=>$this->invoice_items_count,
            'compeleted_date'=>$this->compeleted_date ?? '-',
            'invoice_items'=>InvoiceItemsResource::collection($this->whenLoaded('invoiceItems'))
        ];
    }
}
