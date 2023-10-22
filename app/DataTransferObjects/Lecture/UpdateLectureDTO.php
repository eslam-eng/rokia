<?php

namespace App\DataTransferObjects\Lecture;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\LecturesTypeEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateLectureDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string  $title,
        public float   $price,
        public int     $status,
        public mixed   $is_paid,
        public ?string $description = null,
        public ?string $type = null,
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            title: $request->title,
            price: $request->price,
            status: $request->status,
            is_paid: $request->is_paid,
            description: $request->description,
            type: $request->type,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            title: Arr::get($data, 'title'),
            price: Arr::get($data, 'price'),
            status: Arr::get($data, 'status'),
            is_paid: Arr::get($data, 'is_paid'),
            description: Arr::get($data, 'description'),
            type: Arr::get($data, 'type'),
        );
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|numeric',
            'status' => ['required', Rule::in(ActivationStatus::values())],
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(LecturesTypeEnum::values())],
            'is_paid' => ['required', Rule::in(PaymentStatusEnum::values())],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "price" => $this->is_paid ? $this->price : 0,
            "status" => $this->status,
            "description" => $this->description,
            "type" => $this->type,
            "is_paid" => $this->is_paid,
        ];
    }
}
