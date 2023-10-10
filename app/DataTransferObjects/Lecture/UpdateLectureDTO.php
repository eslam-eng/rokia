<?php

namespace App\DataTransferObjects\Lecture;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
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
            description: Arr::get($data, 'description'),
            type: Arr::get($data, 'type'),
        );
    }

    public static function rules(): array
    {
        return [
            'title'         => 'required|string',
            'price'         => 'required|numeric',
            'status'        => ['required',Rule::in(ActivationStatus::values())],
            'description'   => 'nullable|string',
            'type'          => ['required', Rule::in(['free', 'paid'])],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "title"         => $this->title,
            "price"         => $this->price,
            "status"        => $this->status,
            "description"   => $this->description,
            "type"          => $this->type,
        ];
    }
}
