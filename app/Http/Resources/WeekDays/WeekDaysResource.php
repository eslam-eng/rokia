<?php

namespace App\Http\Resources\WeekDays;

use App\Enums\WeekDaysEnum;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WeekDaysResource extends JsonResource
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
            'id'=>$this->resource,
            'name'=>WeekDaysEnum::from($this->resource)->getLabel()
        ];
    }
}
