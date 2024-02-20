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
        public array $schedule = [],
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            day_id: $request->day_id,
            therapist_id: $request->therapist_id,
            schedule: $request->schedule,
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
            schedule: Arr::get($data, 'schedule'),
        );
    }

    public static function rules(): array
    {
        return [
            'day_id' => 'required|integer',
            'therapist_id' => 'required|integer',
            'schedule.*' => 'required|array|min:1',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i',
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
            'schedule' => $this->schedule
        ];
    }
}
