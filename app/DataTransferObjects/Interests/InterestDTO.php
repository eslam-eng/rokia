<?php

namespace App\DataTransferObjects\Interests;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;

class InterestDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string  $name,
        public bool  $status ,
    )
    {
        $this->status = $this->status ?? ActivationStatus::ACTIVE->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            name: $request->name,
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
            name: Arr::get($data, 'name'),
            status: Arr::get($data, 'status'),
        );
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'status' => 'required|boolean',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "status" => $this->status,
        ];
    }
}
