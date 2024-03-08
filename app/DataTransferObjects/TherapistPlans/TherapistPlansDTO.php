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
        public int  $roznama_number ,
        public float  $price ,
        public bool  $status,
        public ?int  $therapist_id,
        public ?array  $interests = [],
    )
    {
        $this->status = $this->status ?? ActivationStatus::ACTIVE->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            roznama_number: $request->roznama_number,
            price: $request->price,
            status: $request->status ?? ActivationStatus::ACTIVE->value,
            therapist_id: $request->therapist_id,
            interests: $request->interests,
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
            roznama_number: Arr::get($data, 'roznama_number'),
            price: Arr::get($data, 'price'),
            status: Arr::get($data, 'status',ActivationStatus::ACTIVE->value),
            therapist_id: Arr::get($data, 'therapist_id'),
            interests: Arr::get($data, 'interests'),
        );
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'roznama_number' => 'required|integer',
            'price' => 'required|numeric|min:1',
            'status' => ['required',Rule::in(ActivationStatus::values())],
            'therapist_id' => 'required|integer',
            'interests' => 'required|array|min:1',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "roznama_number" => $this->roznama_number,
            "price" => $this->price,
            "status" => $this->status,
            "therapist_id" => $this->therapist_id,
            "interests" => $this->interests,
        ];
    }
}
