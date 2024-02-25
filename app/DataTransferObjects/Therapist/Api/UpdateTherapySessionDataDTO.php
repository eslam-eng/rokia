<?php

namespace App\DataTransferObjects\Therapist\Api;

use App\DataTransferObjects\BaseDTO;
use Illuminate\Support\Arr;

class UpdateTherapySessionDataDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public int $avg_therapy_duration,
        public float $therapy_price,
        public array $specialists = [],
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            avg_therapy_duration: $request->avg_therapy_duration,
            therapy_price: $request->therapy_price,
            specialists: $request->specialists,

        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            avg_therapy_duration: Arr::get($data,'avg_therapy_duration'),
            therapy_price: Arr::get($data,'therapy_price'),
            specialists: Arr::get($data,'specialists'),

        );
    }

    public static function rules(): array
    {
        return [
            'specialists' => 'required|array|min:1',
            'specialists.*' => 'required|exists:specialists,id',
            'avg_therapy_duration' => 'required|integer|min:1',
            'therapy_price' => 'required|numeric',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "avg_therapy_duration" => $this->avg_therapy_duration,
            "therapy_price" => $this->therapy_price,
            "specialists" => $this->specialists,
        ];
    }
}
