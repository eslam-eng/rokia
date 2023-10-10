<?php

namespace App\Http\Requests\Lecture;

use App\Enums\ActivationStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class LectureRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'therapist_id' => 'required|integer',
            'price' => 'required_if:type,paid',
            'status' => ['required', Rule::in(ActivationStatus::values())],
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['free', 'paid'])],
            'image_cover' => 'nullable|file|mimes:png,jpg,jpeg',
            'audio_file' => 'required|file|mimetypes:audio/*|max:307200', // 300 MB
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'therapist_id' => auth()->id(),
        ]);
    }
}
