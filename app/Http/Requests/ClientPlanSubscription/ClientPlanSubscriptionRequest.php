<?php

namespace App\Http\Requests\ClientPlanSubscription;

use App\Enums\ClientPlanStatusEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ClientPlanSubscriptionRequest extends BaseRequest
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
            'client_id' => 'required|integer',
            'therapist_plan_id' => 'required|integer',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['client_id' => auth()->id()]);
    }
}
