<?php

namespace App\DataTransferObjects\BookAppointment;

use App\DataTransferObjects\BaseDTO;
use App\Enums\BookAppointmentStatusEnum;
use App\Enums\WeekDaysEnum;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class BookAppointmentDTO extends BaseDTO
{

    /**
     * @param string $name
     */
    public function __construct(
        public int     $day_id,
        public int     $price,
        public string  $time,
        public ?int    $client_id = null,
        public ?int    $therapist_id = null,
        public ?int    $status = null,
        public ?string $user_description = null,
    )
    {
            $this->status ?? BookAppointmentStatusEnum::PENDING->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            day_id: $request->day_id,
            price: $request->price,
            time: $request->time,
            client_id: $request->client_id,
            therapist_id: $request->therapist_id,
            status: $request->status,
            user_description: $request->user_description,
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
            price: Arr::get($data, 'price'),
            time: Arr::get($data, 'time'),
            client_id: Arr::get($data, 'client_id'),
            therapist_id: Arr::get($data, 'therapist_id'),
            status: Arr::get($data, 'status', BookAppointmentStatusEnum::PENDING->value),
            user_description: Arr::get($data, 'user_description'),
        );
    }

    public static function rules(): array
    {
        return [
            'day_id' => ['required', Rule::in(WeekDaysEnum::values())],
            'price' => 'required|integer',
            'time' => 'required|string|date_format:H:i',
            'date' => 'required|string',
            'client_id' => 'required|integer',
            'therapist_id' => 'required|integer',
            'status' => ['required', Rule::in(BookAppointmentStatusEnum::values())],
            'user_description' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "day_id" => $this->day_id,
            "price" => $this->price,
            "time" => $this->time,
            "date" => getDateForBookAppointment(day_id: $this->day_id,appointment_time: $this->time),
            "client_id" => $this->client_id,
            "therapist_id" => $this->therapist_id,
            "status" => $this->status,
            "user_description" => $this->user_description,
        ];
    }
}
