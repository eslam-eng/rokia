<?php

namespace App\Http\Requests\BookAppointment;

use App\Enums\WeekDaysEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class BookAppointmentRequest extends BaseRequest
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
            'therapist_id' => 'required|integer|exists:therapists,id',
            'time' => 'required|date_format:h:i A',
            'day_id' => ['required','integer',Rule::in(WeekDaysEnum::values())],
            'user_description' => 'nullable|string',
        ];
    }

}
