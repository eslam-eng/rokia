<?php

namespace App\DataTransferObjects\Client;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ClientDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $name,
        public ?string $phone,
        public string $email,
        public string $password,
        public ?string $gender,
        public ?int $status,
        public ?string $device_token = null,
        public ?string $address = null,
        public ?int $city_id = null,
        public ?int $area_id = null,

    )
    {
        $this->status = ActivationStatus::ACTIVE->value;
        $this->gender = GenderTypeEnum::MALE->value;
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
        );
    }

    public static function rules(): array
    {
       return [
           'name'=>'required|string',
           'phone'=>'required|string',
           'email'=>'required|string',
           'password'=>'required|string',
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
            "password" =>bcrypt($this->password),
            "gender" => $this->gender,
            "status" => $this->status,
            "device_token" => $this->device_token,
            "address" => $this->address,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "type" => UsersType::CLIENT->value,
        ];
    }
}
