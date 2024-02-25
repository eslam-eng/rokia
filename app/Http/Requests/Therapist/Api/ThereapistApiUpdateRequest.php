<?php

namespace App\Http\Requests\Therapist\Api;

use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ThereapistApiUpdateRequest extends BaseRequest
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
            'phone' => 'required|string',
            'gender' => ['required', Rule::in(GenderTypeEnum::values())],
            'address' => 'required|string',
        ];
    }
}
