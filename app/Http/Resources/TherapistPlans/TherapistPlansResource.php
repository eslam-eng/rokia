<?php

namespace App\Http\Resources\TherapistPlans;

use App\Enums\ActivationStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistPlansResource extends JsonResource
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
            'name'=>$this->name,
            'duration'=>$this->duration,
            'price'=>$this->price,
            'status'=>$this->status,
            'status_text'=>ActivationStatus::from($this->status)->getLabel()
        ];
    }
}
