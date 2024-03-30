<?php

namespace App\DataTransferObjects\Rate;

use App\DataTransferObjects\BaseDTO;
use App\Enums\RateType;
use Illuminate\Support\Arr;

class RateDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public int     $relatable_id,
        public string  $relatable_type,
        public int     $rate_number,
        public ?string $comment = null,
        public ?int    $user_id = null,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            relatable_id: $request->relatable_id,
            relatable_type: $request->relatable_type,
            rate_number: $request->rate_number,
            comment: $request->comment,
            user_id: $request->user_id,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            relatable_id: Arr::get($data, 'relatable_id'),
            relatable_type: Arr::get($data, 'relatable_type'),
            rate_number: Arr::get($data, 'rate_number'),
            comment: Arr::get($data, 'comment'),
            user_id: Arr::get($data, 'user_id'),
        );
    }

    public static function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'relatable_id' => 'required|integer',
            'relatable_type' => 'required|string|in:' . implode(',', RateType::values()),
            'rate_number' => 'required|integer',
            'comment' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'relatable_id' => $this->relatable_id,
            'relatable_type' => $this->relatable_type,
            'rate_number' => $this->rate_number,
            'comment' => $this->comment,
        ];
    }
}
