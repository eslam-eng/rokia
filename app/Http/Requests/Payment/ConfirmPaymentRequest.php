<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\BaseRequest;

class ConfirmPaymentRequest extends BaseRequest
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
            'merchant_id' => 'required|integer',
            'transaction_id' => 'required|string',
        ];
    }
}
