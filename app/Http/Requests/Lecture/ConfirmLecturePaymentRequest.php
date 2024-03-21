<?php

namespace App\Http\Requests\Lecture;

use App\Enums\ActivationStatus;
use App\Enums\LecturesTypeEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ConfirmLecturePaymentRequest extends BaseRequest
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
