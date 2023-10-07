<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
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
            'name'=>$this->name,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'email'=>$this->email,
            'gender'=>$this->gender,
            'profile_img' => $this->profile_img_url
        ];
    }
}
