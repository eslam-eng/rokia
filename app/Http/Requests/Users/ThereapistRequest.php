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
            'profile_image' => 'nullable|file|mimes:png,jpg,jpeg,svg',
            'documents' => 'nullable|array|min:1',
            'documents.*' => 'file|mimes:png,jpg,jpeg,svg',
            'type' => ['required',Rule::in(UsersType::values())],
            'status' => ['required',Rule::in(ActivationStatus::values())],
            'gender' => ['required',Rule::in(GenderTypeEnum::values())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'type'=>UsersType::THERAPIST->value,
            'status'=>isset($this->status) ? $this->status : ActivationStatus::PENDING->value
        ]);
    }
}
