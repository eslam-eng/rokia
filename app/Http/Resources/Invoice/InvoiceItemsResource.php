<?php

namespace App\Http\Resources\Invoice;

use App\Enums\InvoiceItemTypeEnum;
use App\Http\Resources\Invoice\InvoiceItemDetails\LectureResource;
use App\Http\Resources\TherapistPlans\TherapistPlansResource;
use App\Models\Lecture;
use App\Models\Therapist;
use App\Models\TherapistPlan;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'title'=>InvoiceItemTypeEnum::from($this->type)->getLabel(),
            'client_name'=>$this->client->name,
            'price'=>$this->price,
            'therapist_commission'=>$this->therapist_commission,
            'created_at'=>$this->created_at->format('Y-m-d'),
            'details'=>json_decode($this->details),
        ];
    }
}
