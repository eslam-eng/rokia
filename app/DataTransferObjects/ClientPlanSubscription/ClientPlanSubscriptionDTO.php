<?php

namespace App\DataTransferObjects\ClientPlanSubscription;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\ClientPlanStatusEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ClientPlanSubscriptionDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string  $therapist_plan_id ,
        public float  $client_id ,
        public ?int  $therapist_id = null,
        public ?int  $rozmana_number=null,
        public ?int  $status = null,
        public ?int  $payment_status = null,
        public ?float  $price = null,
    )
    {
        $this->payment_status = $this->payment_status ?? PaymentStatusEnum::NOTPAID->value;
        $this->status = $this->status ?? ClientPlanStatusEnum::RUNNING->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            therapist_plan_id: $request->therapist_plan_id,
            client_id: $request->client_id,
            therapist_id: $request->therapist_id,
            rozmana_number: $request->rozmana_number,
            status: $request->status,
            payment_status: $request->payment_status,
            price: $request->price,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            therapist_plan_id: Arr::get($data, 'therapist_plan_id'),
            client_id: Arr::get($data, 'client_id'),
            therapist_id: Arr::get($data, 'therapist_id'),
            rozmana_number: Arr::get($data, 'rozmana_number'),
            status: Arr::get($data, 'status',ClientPlanStatusEnum::RUNNING->value),
            payment_status: Arr::get($data, 'payment_status',PaymentStatusEnum::NOTPAID->value),
            price: Arr::get($data, 'price'),
        );
    }

    public static function rules(): array
    {
        return [
            'therapist_plan_id' => 'required|integer',
            'client_id' => 'required|integer',
            'therapist_id' => 'required|integer',
            'rozmana_number' => 'required|integer|min:1',
            'status' => ['required',Rule::in(ClientPlanStatusEnum::values())],
            'payment_status' => ['required',Rule::in(PaymentStatusEnum::values())],
            'price' => 'required|numeric|min:1',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "therapist_plan_id" => $this->therapist_plan_id,
            "client_id" => $this->client_id,
            "therapist_id" => $this->therapist_id,
            "rozmana_number" => $this->rozmana_number,
            "status" => $this->status,
            "payment_status" => $this->payment_status,
            "price" => $this->price,
        ];
    }
}
