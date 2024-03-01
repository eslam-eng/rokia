<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'is_active' => 'required|boolean',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
