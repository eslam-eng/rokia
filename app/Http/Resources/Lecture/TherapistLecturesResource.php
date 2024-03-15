<?php

namespace App\Http\Resources\Lecture;

use App\Enums\PaymentStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistLecturesResource extends JsonResource
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
            'title'=>$this->title,
            'description'=>$this->description,
            'duration'=>$this->duration,
            'price'=>$this->when($this->is_paid == PaymentStatusEnum::PAID->value,$this->price),
            'is_paid'=>$this->is_paid,
            'image_cover' =>$this->image_cover_url,
            'audio_file' =>$this->lecture_media_content_url,
        ];
    }
}
