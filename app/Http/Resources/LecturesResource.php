<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturesResource extends JsonResource
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
            'title'=>$this->name,
            'description'=>$this->phone,
            'duration'=>$this->address,
            'price'=>$this->when($this->type == 'paid',$this->price),
            'type'=>$this->type,
            'image_cover' =>$this->image_cover,
            'content' =>$this->lecture_content,
        ];
    }
}
