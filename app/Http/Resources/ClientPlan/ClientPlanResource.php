<?php

namespace App\Http\Resources\ClientPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientPlanResource extends JsonResource
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
            'name'=>$this->therapistPlan->name,
            'roznam_number'=>$this->rozmana_number,
            'remaining'=>$this->client_plan_notification_count
        ];
    }
}
