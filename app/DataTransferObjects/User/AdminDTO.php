<?php

namespace App\DataTransferObjects\User;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use Illuminate\Support\Arr;

class AdminDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string  $name,
        public ?string $phone,
        public string  $email,
        public int     $role_id,
        public ?string $gender,
        public ?int    $status,
        public ?string  $password = null,
        public ?string $address = null,
        public ?int    $city_id = null,
        public ?int    $area_id = null,

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
            role_id: $request->role_id,
            gender: $request->gender,
            status: $request->status,
            password: $request->password,
            address: $request->address,
            city_id: $request->city_id,
            area_id: $request->area_id
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
            phone: Arr::get($data, 'phone'),
            email: Arr::get($data, 'email'),
            role_id: Arr::get($data, 'role_id'),
            gender: Arr::get($data, 'gender'),
            status: Arr::get($data, 'status'),
            password: Arr::get($data, 'password'),
            address: Arr::get($data, 'address'),
            city_id: Arr::get($data, 'city_id'),
            area_id: Arr::get($data, 'area_id'),
        );
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'sometimes|string',
            'address' => 'required|string',
            'status' => 'required|boolean',
            'role_id' => 'required|integer',
            'gender'=>'required|string'
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
            "password" => bcrypt($this->password),
            "gender" => $this->gender,
            "status" => $this->status,
            "address" => $this->address,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "type" => UsersType::ADMIN->value,
            "role_id" => $this->role_id,
        ];
    }
}
