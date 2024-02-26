<?php

namespace App\Http\Resources\Appointments;

use App\Enums\BookAppointmentStatusEnum;
use App\Enums\WeekDaysEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class BookAppointmentsResource extends JsonResource
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
            'client_id'=>$this->client->id,
            'client_name'=>$this->client->name,
            'therapist_id'=>$this->therapist->id,
            'therapist_name'=>$this->therapist->name,
            'date'=>$this->date,
            'time'=>$this->time,
            'day_id'=>$this->day_id,
            'day_name'=>WeekDaysEnum::from($this->day_id)->getLabel(),
            'status'=>$this->status,
            'status_text'=>BookAppointmentStatusEnum::from($this->status)->getLabel(),
            'user_description'=>$this->user_description,
        ];
    }
}
