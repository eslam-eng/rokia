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
        public ?string $phone,
        public string $email,
        public ?string $password = null,
        public ?string $gender,
        public ?int $status,
        public ?int $type,
        public ?string $device_token = null,
        public ?string $address = null,
        public ?int $city_id = null,
        public ?int $area_id = null,
        public $profile_image = null,
        public array $documents = [],
        public ?string $therapist_commission = null,

    )
    {
        $this->type = UsersType::THERAPIST->value ;
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
            type: $request->type,
            device_token: $request->device_token,
            address: $request->address,
            city_id: $request->city_id,
            area_id: $request->area_id,
            profile_image: $request->profile_image,
            documents: $request->documents ?? [],
            therapist_commission: $request->therapist_commission,
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
            type: Arr::get($data,'type'),
            device_token: Arr::get($data,'device_token'),
            address: Arr::get($data,'address'),
            city_id: Arr::get($data,'city_id'),
            area_id: Arr::get($data,'area_id'),
            profile_image: Arr::get($data,'profile_image'),
            documents: Arr::get($data,'documents',[]),
            therapist_commission: Arr::get($data,'therapist_commission',[]),
        );
    }

    public static function rules(): array
    {
       return [
           'name'=>'required|string',
           'phone'=>'required|string',
           'email'=>'required|string',
           'password'=>'required|string',
           'profile_image'=>'nullable|string',
           'type'=>['required',Rule::in(UsersType::values())],
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
            "password" =>isset($this->password) ? bcrypt($this->password) : null,
            "gender" => $this->gender,
            "status" => $this->status,
            "address" => $this->address,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "type" => $this->type,
            "documents" => $this->documents,
            "therapist_commission" => $this->therapist_commission,
        ];
    }
}
