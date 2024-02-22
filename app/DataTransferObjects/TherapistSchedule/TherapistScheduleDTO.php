<?php

namespace App\DataTransferObjects\TherapistSchedule;

use App\DataTransferObjects\BaseDTO;
use Illuminate\Support\Arr;

class TherapistScheduleDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public int   $day_id,
        public ?int  $therapist_id = null,
        public array $schedules = [],
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            day_id: $request->day_id,
            therapist_id: $request->therapist_id,
            schedules: $request->schedules,
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
            therapist_id: Arr::get($data, 'therapist_id'),
            schedules: Arr::get($data, 'schedules'),
        );
    }

    public static function rules(): array
    {
        return [
            'day_id' => 'required|integer',
            'therapist_id' => 'required|integer',
            'schedules.*' => 'required|array|min:1',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "day_id" => $this->day_id,
            "therapist_id" => $this->therapist_id,
            'schedules' => $this->schedules
        ];
    }
}
