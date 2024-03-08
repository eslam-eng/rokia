<?php

namespace App\Http\Resources;

use App\Http\Resources\Category\InterestsResource;
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
            'time'=>$this->time,
            'status'=>$this->status,
            'interests'=>InterestsResource::collection($this->whenLoaded('interests'))
        ];
    }

}
