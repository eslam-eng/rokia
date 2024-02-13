<?php

namespace App\Http\Requests\TherapistSchedule;

use App\Http\Requests\BaseRequest;

class TherapistSceduleRequest extends BaseRequest
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
            'day_id' => 'required|integer',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'therapist_id' => 'required|integer',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['therapist_id' => auth()->guard('api_therapist')->id()]);
    }
}
