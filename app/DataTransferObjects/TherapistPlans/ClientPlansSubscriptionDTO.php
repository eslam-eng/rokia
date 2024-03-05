<?php

namespace App\DataTransferObjects\TherapistPlans;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ClientPlanStatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ClientPlansSubscriptionDTO extends BaseDTO
{

    /**
     * @param string $name
     * 'client_id','therapist_id','therapist_plan_id','rozmana_number','price','status'
     */

    public function __construct(
        public int $client_id,
        public int $therapist_id,
        public int $therapist_plan_id,
        public int $rozmana_number,
        public int $price,
        public int $status
    )
    {
        $this->status = $this->status ?? ClientPlanStatusEnum::PENDING->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            client_id: $request->client_id,
            therapist_id: $request->therapist_id,
            therapist_plan_id: $request->therapist_plan_id,
            rozmana_number: $request->rozmana_number,
            price: $request->price,
            status: $request->status ?? ClientPlanStatusEnum::PENDING->value,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            client_id: Arr::get($data, 'client_id'),
            therapist_id: Arr::get($data, 'therapist_id'),
            therapist_plan_id: Arr::get($data, 'therapist_plan_id'),
            rozmana_number: Arr::get($data, 'rozmana_number'),
            price: Arr::get($data, 'price'),
            status: Arr::get($data, 'status'),
        );
    }

    public static function rules(): array
    {
        return [
            'client_id' => 'required|integer',
            'therapist_id' => 'required|integer',
            'therapist_plan_id' => 'required|integer',
            'rozmana_number' => 'required|integer',
            'price' => 'required|integer',
            'status' => ['required', Rule::in(ClientPlanStatusEnum::values())],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "client_id" => $this->client_id,
            "therapist_id" => $this->therapist_id,
            "therapist_plan_id" => $this->therapist_plan_id,
            "rozmana_number" => $this->rozmana_number,
            "price" => $this->price,
            "status" => $this->status,
        ];
    }
}
