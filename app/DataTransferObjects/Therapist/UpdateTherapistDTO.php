<?php

namespace App\DataTransferObjects\Therapist;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateTherapistDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $name,
        public string $phone,
        public ?string $gender,
        public ?string $password,
        public int $avg_therapy_duration,
        public ?string $address = null,
        public ?int $city_id = null,
        public ?int $area_id = null,
        public ?int $therapist_commission = null,
        public ?int $status = null,

    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            phone: $request->phone,
            gender: $request->gender,
            password: $request->password,
            avg_therapy_duration: $request->avg_therapy_duration,
            address: $request->address,
            city_id: $request->city_id,
            area_id: $request->area_id,
            therapist_commission: $request->therapist_commission,
            status: $request->status,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            name: Arr::get($data,'name'),
            phone: Arr::get($data,'phone'),
            gender: Arr::get($data,'gender'),
            password: Arr::get($data,'password'),
            avg_therapy_duration: Arr::get($data,'avg_therapy_duration'),
            address: Arr::get($data,'address'),
            city_id: Arr::get($data,'city_id'),
            area_id: Arr::get($data,'area_id'),
            therapist_commission: Arr::get($data,'therapist_commission'),
            status: Arr::get($data,'status',ActivationStatus::PENDING->value),
        );
    }

    public static function rules(): array
    {
       return [
           'name'=>'required|string',
           'phone'=>'required|string',
           'gender'=>'required|string',
           'address'=>'required|string',
           'therapist_commission'=>'required|numeric|min:1',
           'password'=>'nullable|string',
           'avg_therapy_duration'=>'required|integer',
           'status'=>['required',Rule::in(ActivationStatus::values())]
       ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "phone" => $this->phone,
            "gender" => $this->gender,
            "address" => $this->address,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "avg_therapy_duration" => $this->avg_therapy_duration,
            "password" => $this->password,
            "therapist_commission" => $this->therapist_commission,
            "status" => $this->status,
        ];
    }
}
