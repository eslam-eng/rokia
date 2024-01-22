<?php

namespace App\Http\Requests\Slider;

use App\Http\Requests\BaseRequest;

class SliderRequest extends BaseRequest
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
            'image' => 'required|file|mimes:jpg,jpeg,png,gif',
            'order' => 'required|integer',
            'status' => 'required|bool',
            'caption' => 'nullable|string',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['status' => $this->boolean('status')]);
    }
}
