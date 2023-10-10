<?php

namespace App\Http\Requests\Wishlist;

use App\Enums\ActivationStatus;
use App\Http\Requests\BaseRequest;
use App\Models\Lecture;
use Illuminate\Validation\Rule;

class WishlistRequest extends BaseRequest
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
            'relatable_id' => 'required|string',
            'relatable_type' => 'required|string',
            'notes' => 'nullable|string',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' =>auth()->id(),
            'relatable_type' =>get_class(new Lecture()),
        ]);
    }
}
