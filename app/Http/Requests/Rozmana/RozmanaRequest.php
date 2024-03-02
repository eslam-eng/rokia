<?php

namespace App\Http\Requests\Rozmana;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RozmanaRequest extends BaseRequest
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
            'description' => 'required|string',
            'therapist_id' => 'required|exists:users,id',
            'date'=>'required|date_format:d-m',
            'time'=>'required|date_format:H:i',
            'interests'=>'required|array|min:1'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'therapist_id' => auth()->id(),
        ]);
    }
}
