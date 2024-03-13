<?php

namespace App\DataTransferObjects\Rate;

use App\Enums\RateType;
use App\DataTransferObjects\BaseDTO;
use Illuminate\Support\Arr;

class RateDTO extends BaseDTO
{
    public int $user_id;
    public int $relatable_id;
    public string $relatable_type;
    public int $rate_number;

    public static function createFromArray(array $data): self
    {
        return new self([
            'user_id' => $data['user_id'],
            'relatable_id' => $data['relatable_id'],
            'relatable_type' => $data['relatable_type'],
            'rate_number' => $data['rate_number'],
        ]);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'relatable_id' => $this->relatable_id,
            'relatable_type' => $this->relatable_type,
            'rate_number' => $this->rate_number,
        ];
    }

    public static function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'relatable_id' => 'required|integer',
            'relatable_type' => 'required|integer|in:' . implode(',', RateType::values()),
            'rate_number' => 'required|integer',
        ];
    }

    public static function fromArray(array $data): RateDTO
    {
        return new self($data);
    }

    public static function fromRequest(\Illuminate\Http\Request $request): RateDTO
    {
        return static::createFromArray($request->all());
    }
}
