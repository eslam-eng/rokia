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
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'boolean|required',
            'therapist_id' => 'required|exists:users,id'
        ];
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['date'] = ['required', 'date_format:d-m', Rule::unique('rozmanas')->where('therapist_id', auth()->id())->ignore($this->rozmana)]; // Assuming the route parameter name is 'id'
        } else {
            $rules['date'] = ['required','date_format:d-m', Rule::unique('rozmanas')->where('therapist_id', auth()->id())];
        }
        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'therapist_id' => auth()->id(),
        ]);
    }
}
