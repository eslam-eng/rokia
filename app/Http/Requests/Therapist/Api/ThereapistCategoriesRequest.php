<?php

namespace App\Http\Requests\Therapist\Api;

use App\Enums\GenderTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ThereapistCategoriesRequest extends BaseRequest
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
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:categories,id',
        ];
    }
}
