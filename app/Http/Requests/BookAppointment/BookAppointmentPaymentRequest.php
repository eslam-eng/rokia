<?php

namespace App\Http\Requests\BookAppointment;

use App\Http\Requests\BaseRequest;

class BookAppointmentPaymentRequest extends BaseRequest
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
            'book_appointment_id' => 'required|integer|exists:book_appointments,id',
            'client_id' => 'required|integer',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['client_id' => auth()->id()]);
    }

}
