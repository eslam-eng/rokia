<?php

namespace App\Http\Requests\TherapistPlan;

use App\Http\Requests\BaseRequest;

class TherapistPlanRequest extends BaseRequest
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
            'duration' => 'required|integer',
            'price' => 'required|integer',
        ];
    }
}