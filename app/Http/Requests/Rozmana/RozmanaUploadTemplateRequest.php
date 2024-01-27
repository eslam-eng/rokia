<?php

namespace App\Http\Requests\Rozmana;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RozmanaUploadTemplateRequest extends BaseRequest
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
            'file' => 'required|file|mimes:xlsx',
        ];

    }

}
