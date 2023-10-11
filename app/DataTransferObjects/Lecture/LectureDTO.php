<?php

namespace App\DataTransferObjects\Lecture;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use App\Enums\LecturesTypeEnum;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class LectureDTO extends BaseDTO
{

    /**
     * @param string $name
     */

    public function __construct(
        public string  $title,
        public int     $therapist_id,
        public float   $price,
        public int     $status,
        public ?string $duration,
        public mixed $publish_date,
        public ?string $description = null,
        public ?string $type = null,
        public int $is_paid = 0, // 0 or 1
        public mixed $image_cover = null,
        public mixed $audio_file = null,

    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            title: $request->title,
            therapist_id: $request->therapist_id,
            price: $request->price,
            status: $request->status,
            duration: $request->duration,
            publish_date: $request->publish_date,
            description: $request->description,
            type: $request->type,
            is_paid: $request->is_paid,
            image_cover: $request->image_cover,
            audio_file: $request->audio_file
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
            therapist_id: Arr::get($data, 'therapist_id'),
            price: Arr::get($data, 'price'),
            status: Arr::get($data, 'status'),
            duration: Arr::get($data, 'duration'),
            publish_date: Arr::get($data, 'publish_date'),
            description: Arr::get($data, 'description'),
            type: Arr::get($data, 'type'),
            is_paid: Arr::get($data, 'is_paid'),
            image_cover: Arr::get($data, 'image_cover'),
            audio_file: Arr::get($data, 'audio_file'),

        );
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|string',
            'therapist_id' => 'required|integer',
            'price' => 'required_if:is_paid,1',
            'is_paid' => 'required|numeric',
            'status' => ['required',Rule::in(ActivationStatus::values())],
            'duration' => 'nullable|string',
            'description' => 'nullable|string',
            'publish_date' => 'date|after_or_equal:today',
            'type' => ['required', Rule::in(LecturesTypeEnum::values())],
            'image_cover' => 'nullable|file|mimes:png,jpg,jpeg',
            'audio_file' => ['file','mimetypes:audio/*','max:307200',Rule::requiredIf(request()->url() == route('lectures.store'))], // 300 MB
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "therapist_id" => $this->therapist_id,
            "price" => $this->price,
            "is_paid" => $this->price,
            "status" => $this->status,
            "duration" => $this->duration,
            "description" => $this->description,
            "type" => $this->type,
            "publish_date" => $this->audio_file,
            "audio_file" => $this->audio_file,
        ];
    }
}
