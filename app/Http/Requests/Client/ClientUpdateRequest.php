<?php

namespace App\Http\Requests\Client;

use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Enums\UsersType;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends BaseRequest
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
            'address'=>'nullable|string',
            'gender' => ['required', Rule::in(GenderTypeEnum::values())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
                'type' => UsersType::CLIENT->value,
                'status' => ActivationStatus::ACTIVE->value
            ]
        );
    }
}
