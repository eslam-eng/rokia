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
            'schedule' => 'required|array|min:1',
            'schedule.*' => 'required|array|min:1',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i',
        ];
    }

}
