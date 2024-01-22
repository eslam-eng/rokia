<?php

namespace App\DataTransferObjects\Slider;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;

class SliderDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public mixed  $image,
        public int  $order,
        public bool  $status ,
        public ?string $caption = null,
    )
    {
        $this->status = ActivationStatus::ACTIVE->value;
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            image: $request->image,
            order: $request->order,
            status: $request->status,
            caption: $request->caption,
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            image: Arr::get($data, 'image'),
            order: Arr::get($data, 'order'),
            status: Arr::get($data, 'status'),
            caption: Arr::get($data, 'caption'),
        );
    }

    public static function rules(): array
    {
        return [
            'image' => 'required|file|mimes:jpg,jpeg,png,gif',
            'order' => 'required|integer',
            'status' => 'required|integer',
            'caption' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "image" => $this->image,
            "order" => $this->order,
            "status" => $this->status,
            "caption" => $this->caption,
        ];
    }
}
