<?php

namespace App\Http\Resources\Therapist;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistResource extends JsonResource
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
            'phone'=>$this->phone,
            'address'=>$this->address,
            'email'=>$this->email,
            'gender'=>$this->gender,
            'avg_therapy_duration'=>$this->avg_therapy_duration,
            'therapy_price'=>$this->therapy_price,
            'profile_image_id'=>$this?->getFirstMedia('profile_image')?->id,
            'profile_image_url'=>$this->profile_image_url,
            'specialists'=>TherapistInterestResource::collection($this->whenLoaded('spaecialists'))
        ];
    }
}
