<?php

namespace App\DataTransferObjects\BookAppointment;

use App\DataTransferObjects\BaseDTO;
use App\Enums\BookAppointmentStatusEnum;
use App\Enums\WeekDaysEnum;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class BookAppointmentDTO extends BaseDTO
{

    /**
     * @param string $name
     */
    public function __construct(
        public int     $day_id,
        public string  $time,
        public ?int    $client_id = null,
        public ?int    $therapy_price = null,
        public ?int    $therapist_id = null,
        public ?int    $status = null,
        public ?string $user_description = null,
    )
    {
        $this->status = $this->status ?: BookAppointmentStatusEnum::PENDING->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            day_id: $request->day_id,
            time: $request->time,
            client_id: $request->client_id,
            therapy_price: $request->therapy_price,
            therapist_id: $request->therapist_id,
            status: $request->status ?? BookAppointmentStatusEnum::PENDING->value,
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
            time: Arr::get($data, 'time'),
            client_id: Arr::get($data, 'client_id'),
            therapy_price: Arr::get($data, 'therapy_price'),
            therapist_id: Arr::get($data, 'therapist_id'),
            status: Arr::get($data, 'status', BookAppointmentStatusEnum::PENDING->value),
            user_description: Arr::get($data, 'user_description'),
        );
    }

    public static function rules(): array
    {
        return [
            'day_id' => ['required', Rule::in(WeekDaysEnum::values())],
            'time' => 'required|string|date_format:H:i', //as rueles applys on to array data and we convert time in toArray method to format H:i
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
            "price" => $this->therapy_price,
            "time" => Carbon::createFromFormat('h:i A', $this->time)->format('H:i'),
            "date" => getDateForBookAppointment(day_id: $this->day_id, appointment_time: $this->time),
            "client_id" => $this->client_id,
            "therapist_id" => $this->therapist_id,
            "status" => $this->status,
            "user_description" => $this->user_description,
        ];
    }
}
