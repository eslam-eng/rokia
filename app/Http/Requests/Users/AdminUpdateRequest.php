<?php

namespace App\Http\Requests\Users;

use App\Enums\ActivationStatus;
use App\Http\Requests\BaseRequest;

class AdminUpdateRequest extends BaseRequest
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
            'password' => 'nullable|string',
            'address' => 'required|string',
            'role_id' => 'required|integer',
            'gender' => 'required|string',
            'status'=>'required|boolean'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => ActivationStatus::ACTIVE->value
        ]);
    }
}
