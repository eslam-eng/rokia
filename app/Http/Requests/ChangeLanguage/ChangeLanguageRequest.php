<?php

namespace App\Http\Requests\ChangeLanguage;

use App\Enums\AvailableLanguagesEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ChangeLanguageRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'lang' => ['required',Rule::in(AvailableLanguagesEnum::values())],
        ];
    }
}
