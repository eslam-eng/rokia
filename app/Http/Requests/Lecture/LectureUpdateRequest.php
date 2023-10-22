<?php

namespace App\Http\Requests\Lecture;

use App\Enums\ActivationStatus;
use App\Enums\PaymentStatusEnum;
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
            'price' => 'required_if:type,'.PaymentStatusEnum::PAID->value,
            'status' => ['required', Rule::in(ActivationStatus::values())],
            'description' => 'nullable|string',
            'is_paid' => ['nullable', Rule::in(PaymentStatusEnum::values())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'price' => $this->price ?? 0,
            'is_paid' =>isset($this->is_paid) ? 1 : 0
        ]);
    }
}
