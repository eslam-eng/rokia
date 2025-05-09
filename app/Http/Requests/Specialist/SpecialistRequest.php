<?php

namespace App\Http\Requests\Specialist;

use App\Http\Requests\BaseRequest;

class SpecialistRequest extends BaseRequest
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
            'status' => 'required|bool',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['status' => $this->boolean('status')]);
    }
}
