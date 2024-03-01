<?php

namespace App\DataTransferObjects\Role;

use App\DataTransferObjects\BaseDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RoleDTO extends BaseDTO
{
    public function __construct(public string $name, public string $guard_name, public bool $is_active)
    {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->name,
            guard_name: $request->get('guard_name', 'web'),
            is_active: $request->get('is_active'),
        );
    }

    /**
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            name: Arr::get($data, 'name'),
            guard_name: Arr::get($data, 'guard_name', 'web'),
            is_active: Arr::get($data, 'is_active'),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'is_active' => $this->is_active,
        ];
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'guard_name' => 'required|string',
            'is_active' => 'required|boolean',
        ];
    }
}
