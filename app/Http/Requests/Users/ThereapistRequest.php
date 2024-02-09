<?php

namespace App\Http\Requests\Users;

use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ThereapistRequest extends BaseRequest
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
            'email' => 'required|string',
            'password' => 'required|string',
            'status' => ['required',Rule::in(ActivationStatus::values())],
            'gender' => ['required',Rule::in(GenderTypeEnum::values())],
            'categories'=>'required|array|min:1',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'status'=>ActivationStatus::PENDING->value,
            'therapist_commission'=>0
        ]);
    }
}
