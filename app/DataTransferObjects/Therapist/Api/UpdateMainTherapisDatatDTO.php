<?php

namespace App\DataTransferObjects\Therapist\Api;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateMainTherapisDatatDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $name,
        public string $phone,
        public ?string $gender,
        public ?string $password,
        public ?string $address = null,
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
            address: $request->address,
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
            address: Arr::get($data,'address'),
        );
    }

    public static function rules(): array
    {
       return [
           'name'=>'required|string',
           'phone'=>'required|string',
           'gender'=>'required|string',
           'address'=>'required|string',
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
        ];
    }
}
