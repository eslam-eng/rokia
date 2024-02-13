<?php

namespace App\DataTransferObjects\TherapistSchedule;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;

class TherapistScheduleDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public int  $day_id,
        public string  $start_time,
        public string  $end_time ,
        public ?int $therapist_id =null,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            day_id: $request->day_id,
            start_time: $request->start_time,
            end_time: $request->end_time,
            therapist_id: $request->therapist_id,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            day_id: Arr::get($data, 'day_id'),
            start_time: Arr::get($data, 'start_time'),
            end_time: Arr::get($data, 'end_time'),
            therapist_id: Arr::get($data, 'therapist_id'),
        );
    }

    public static function rules(): array
    {
        return [
            'day_id' => 'required|integer',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'therapist_id' => 'required|integer',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "day_id" => $this->day_id,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "therapist_id" => $this->therapist_id,
        ];
    }
}
