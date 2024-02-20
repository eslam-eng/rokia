<?php

namespace App\Http\Requests\BookAppointment;

use App\Http\Requests\BaseRequest;

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
            'theraist_id' => 'required|integer|exists:therapists,id',
            'appointment_time' => 'required|date_format:h:i A',
            'day_id' => 'required|bool',
            'user_description' => 'nullable|string',
        ];
    }

}
