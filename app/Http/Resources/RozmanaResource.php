<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RozmanaResource extends JsonResource
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
            'date'=>$this->date,
            'status'=>$this->status,
            'total'=>$this->total_count
        ];
    }

}