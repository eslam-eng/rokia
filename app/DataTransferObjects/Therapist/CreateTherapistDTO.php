<?php

namespace App\DataTransferObjects\Therapist;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CreateTherapistDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
        public string $password,
        public ?string $gender,
        public ?int $status,
        public ?string $device_token = null,
        public ?string $address = null,
        public ?int $city_id = null,
        public ?int $area_id = null,
        public ?string $therapist_commission = null,
        public ?array $categories = [],

    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            phone: $request->phone,
            email: $request->email,
            password: $request->password,
            gender: $request->gender,
            status: $request->status,
            device_token: $request->device_token,
            address: $request->address,
            city_id: $request->city_id,
            area_id: $request->area_id,
            therapist_commission: $request->therapist_commission,
            categories: $request->categories,
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
            email: Arr::get($data,'email'),
            password: Arr::get($data,'password'),
            gender: Arr::get($data,'gender'),
            status: Arr::get($data,'status'),
            device_token: Arr::get($data,'device_token'),
            address: Arr::get($data,'address'),
            city_id: Arr::get($data,'city_id'),
            area_id: Arr::get($data,'area_id'),
            therapist_commission: Arr::get($data,'therapist_commission',0),
            categories: Arr::get($data,'therapist_commission',[]),
        );
    }

    public static function rules(): array
    {
       return [
           'name'=>'required|string',
           'phone'=>'required|string',
           'email'=>'required|string',
           'password'=>'required|string',
           'gender'=>'required|string',
           'address'=>'required|string',
           'categories'=>'required|array|min:1',
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
            "email" => $this->email,
            "password" =>$this->password,
            "gender" => $this->gender,
            "status" => $this->status,
            "address" => $this->address,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "therapist_commission" => $this->therapist_commission,
            "categories" => $this->categories,
        ];
    }
}
