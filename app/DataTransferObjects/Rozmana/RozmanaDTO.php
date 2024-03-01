<?php

namespace App\DataTransferObjects\Rozmana;

use App\DataTransferObjects\BaseDTO;
use App\Enums\ActivationStatus;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Integer;

class RozmanaDTO extends BaseDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public mixed  $date,
        public int $therapist_id,
        public bool   $status = true,
        public array $interests = []
    )
    {
    }

    public static function fromRequest($request): BaseDTO
    {
        return new self(
            title: $request->title,
            description: $request->description,
            date: $request->date,
            therapist_id: $request->therapist_id,
            status: $request->status,
            interests: $request->interests,
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
            description: Arr::get($data, 'description'),
            date: Arr::get($data, 'date'),
            therapist_id: Arr::get($data, 'therapist_id'),
            status: Arr::get($data, 'status'),
            interests: Arr::get($data, 'interests',[]),
        );
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date_format:d-m',
            'therapist_id' => 'required|integer',
            'status' => 'boolean|required',
            'interests' => 'required|array|min:1',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "therapist_id" => $this->therapist_id,
            "date" => $this->date,
            "status" => $this->status,
            "interests" => $this->interests,
        ];
    }
}
