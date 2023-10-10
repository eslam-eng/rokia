<?php

namespace App\Http\Requests\Lecture;

use App\Enums\ActivationStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class LectureUpdateRequest extends BaseRequest
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
            'price' => 'required_if:type,paid',
            'status' => ['required', Rule::in(ActivationStatus::values())],
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['free', 'paid'])],
        ];
    }
}
