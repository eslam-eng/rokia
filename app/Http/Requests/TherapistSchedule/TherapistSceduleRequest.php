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
            'schedules' => 'required|array',
            'schedules.*' => 'required|array|min:1',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i',
        ];
    }
}
