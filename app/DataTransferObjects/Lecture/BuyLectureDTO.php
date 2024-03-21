<?php

namespace App\DataTransferObjects\Lecture;

use App\DataTransferObjects\BaseDTO;
use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class BuyLectureDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public int     $lecture_id,
        public ?string $lecture_data = null,
        public ?int    $user_id = null,
        public ?int    $payment_status = null
    )
    {
        $this->payment_status = $this->payment_status ?? PaymentStatusEnum::NOTPAID->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            lecture_id: $request->lecture_id,
            lecture_data: $request->lecture_data,
            user_id: $request->user_id,
            payment_status: $request->payment_status
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            lecture_id: Arr::get($data, 'lecture_id'),
            lecture_data: Arr::get($data, 'lecture_data'),
            user_id: Arr::get($data, 'user_id'),
            payment_status: Arr::get($data, 'payment_status'),
        );
    }

    public static function rules(): array
    {
        return [
            'lecture_id' => 'required|integer',
            'lecture_data' => 'required|string',
            'user_id' => 'required|integer',
            'payment_status' => ['required', Rule::in(PaymentStatusEnum::values())],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "lecture_id" => $this->lecture_id,
            "lecture_data" => $this->lecture_data,
            "user_id" => $this->user_id,
            "payment_status" => $this->payment_status,
        ];
    }
}
