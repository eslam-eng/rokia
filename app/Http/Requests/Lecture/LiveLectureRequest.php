<?php

namespace App\Http\Requests\Lecture;

use App\Enums\ActivationStatus;
use App\Enums\LecturesTypeEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class LiveLectureRequest extends BaseRequest
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
            'is_paid' => ['required',Rule::in([0,1])],
            'price' => 'required_if:is_paid,1',
            'status' => ['required', Rule::in(ActivationStatus::values())],
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(LecturesTypeEnum::values())],
            'publish_date' => 'date|after_or_equal:today',
            'image_cover' => 'nullable|file|mimes:png,jpg,jpeg',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'therapist_id' => auth()->id(),
            'type' => LecturesTypeEnum::LIVE->value,

        ]);
    }
}
