<?php

namespace App\DataTransferObjects\Lecture;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class LectureDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string $title,
        public int $user_id,
        public float $price,
        public int $status,
        public ?string $duration,
        public ?string $description = null,
        public ?string $type = null,

    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            title: $request->title,
            user_id: $request->user_id,
            price: $request->price,
            status: $request->status,
            duration: $request->duration,
            description: $request->description,
            type: $request->type
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function fromArray(array $data): BaseDTO
    {
        return new self(
            title: Arr::get($data,'title'),
            user_id: Arr::get($data,'user_id'),
            price: Arr::get($data,'price'),
            status: Arr::get($data,'status'),
            duration: Arr::get($data,'duration'),
            description: Arr::get($data,'description'),
            type: Arr::get($data,'type'),

        );
    }

    public static function rules(): array
    {
       return [
           'title'=>'required|string',
           'user_id'=>'required|integer',
           'price'=>'required|numeric',
           'status'=>'required|string',
           'duration'=>'nullable|string',
           'description'=>'nullable|string',
           'type'=>['required',Rule::in(['free','paid'])],
       ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "user_id" => $this->user_id,
            "price" => $this->price,
            "status" =>$this->status,
            "duration" => $this->duration,
            "description" => $this->description,
            "type" => $this->type,
        ];
    }
}
