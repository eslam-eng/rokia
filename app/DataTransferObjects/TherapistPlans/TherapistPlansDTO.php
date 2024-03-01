<?php

namespace App\DataTransferObjects\TherapistPlans;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TherapistPlansDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string  $name ,
        public int  $duration ,
        public float  $price ,
        public bool  $status,
        public ?int  $therapist_id,
    )
    {
        $this->status = $this->status ?? ActivationStatus::ACTIVE->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            duration: $request->duration,
            price: $request->price,
            status: $request->status ?? ActivationStatus::ACTIVE->value,
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
            name: Arr::get($data, 'name'),
            duration: Arr::get($data, 'duration'),
            price: Arr::get($data, 'price'),
            status: Arr::get($data, 'status',ActivationStatus::ACTIVE->value),
            therapist_id: Arr::get($data, 'therapist_id'),
        );
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'duration' => 'required|integer',
            'price' => 'required|numeric|min:1',
            'status' => ['required',Rule::in(ActivationStatus::values())],
            'therapist_id' => 'required|integer',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "duration" => $this->duration,
            "price" => $this->price,
            "status" => $this->status,
            "therapist_id" => $this->therapist_id,
        ];
    }
}
