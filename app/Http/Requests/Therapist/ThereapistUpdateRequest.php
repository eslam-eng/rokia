<?php

namespace App\Http\Requests\Therapist;

use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ThereapistUpdateRequest extends BaseRequest
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
            'name' => 'required|string',
            'therapist_commission' => 'required|numeric',
            'avg_therapy_duration' => 'required|numeric|min:5',
            'phone' => 'required|string',
            'documents' => 'nullable|array|min:1',
            'documents.*' => 'file|mimes:png,jpg,jpeg,svg',
            'status' => ['required',Rule::in(ActivationStatus::values())],
            'gender' => ['required',Rule::in(GenderTypeEnum::values())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status'=>$this->boolean('status') ? ActivationStatus::ACTIVE->value : ActivationStatus::PENDING->value,
        ]);
    }
}
