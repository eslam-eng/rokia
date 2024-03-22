<?php

namespace App\DataTransferObjects\Rate;

use App\Enums\RateType;
use App\Http\Requests\RateStoreRequest;
use App\DataTransferObjects\BaseDTO;
use Illuminate\Http\Request;

class RateDTO extends BaseDTO
{
    public function __construct(
        public int $relatable_id,
        public string $relatable_type,
        public int $rate_number,
        public ?string $comment = null,
        public ?int $user_id = null,
    ) {
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            relatable_id: $data['relatable_id'] ?? null,
            relatable_type: $data['relatable_type'] ?? null,
            rate_number: $data['rate_number'] ?? null,
            comment: $data['comment'] ?? null,
        );
    }

    public static function createFromRequest(RateStoreRequest $request): self
    {
        return new self(
            user_id: $request->user_id,
            relatable_id: $request->relatable_id,
            relatable_type: $request->relatable_type,
            rate_number: $request->rate_number,
            comment: $request->comment,
        );
    }

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

    public static function fromArray(array $data): RateDTO
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            relatable_id: $data['relatable_id'] ?? null,
            relatable_type: $data['relatable_type'] ?? null,
            rate_number: $data['rate_number'] ?? null,
            comment: $data['comment'] ?? null,
        );
    }

    public static function fromRequest(Request $request): RateDTO
    {
        return new self(
            user_id: $request->input('user_id'),
            relatable_id: $request->input('relatable_id'),
            relatable_type: $request->input('relatable_type'),
            rate_number: $request->input('rate_number'),
            comment: $request->input('comment'),
        );
    }
}
