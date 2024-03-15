<?php

namespace App\DataTransferObjects\Client;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateClientDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $name,
        public string $phone,
        public string $gender,
        public ?string $address = null
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
            phone: $request->phone,
            gender: $request->gender,
            address: $request->address
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
            address: Arr::get($data,'address')
        );
    }

    public static function rules(): array
    {
       return [
           'name'=>'required|string',
           'phone'=>'required|string',
           'gender'=>['required',Rule::in(GenderTypeEnum::values())],
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
            "address" => $this->address,
            "gender" => $this->gender,
        ];
    }
}
