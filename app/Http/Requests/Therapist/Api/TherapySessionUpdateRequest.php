<?php

namespace App\Http\Requests\Therapist\Api;

use App\Enums\GenderTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class TherapySessionUpdateRequest extends BaseRequest
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
            'specialists' => 'required|array|min:1',
            'specialists.*' => 'required|exists:specialists,id',
            'avg_therapy_duration' => 'required|integer|min:1',
            'therapy_price' => 'required|numeric',
        ];
    }
}
