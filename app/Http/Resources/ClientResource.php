<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'profile_img_id' => $this->getFirstMediaUrl('profile_image')?->id ?? null,
            'profile_img_url' => $this->profile_image_url
        ];
    }
}
