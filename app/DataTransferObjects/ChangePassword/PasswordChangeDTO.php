<?php

namespace App\DataTransferObjects\ChangePassword;

use App\DataTransferObjects\BaseDTO;
use App\Enums\UsersType;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PasswordChangeDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $old_password,
        public string $new_password,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            old_password: $request->name,
            new_password: $request->phone,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            old_password: Arr::get($data,'old_password'),
            new_password: Arr::get($data,'new_password')
        );
    }

    public static function rules(): array
    {
       return [
           'old_password'=>'required|string|min:8',
           'new_password'=>'required|string|min:8',
       ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "old_password" => $this->old_password,
            "new_password" => $this->new_password,
        ];
    }
}
