<?php

namespace App\Http\Resources\Therapist;

use App\Enums\WeekDaysEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistScheduleResource extends JsonResource
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
            'day_id'=>$this->day_id,
            'day_name'=>WeekDaysEnum::from($this->day_id)->getLabel(),
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
        ];
    }
}
