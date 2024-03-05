<?php

namespace App\Http\Requests\ClientPlanSubscription;

use App\Enums\ClientPlanStatusEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ClientPlanRequest extends BaseRequest
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
            'therapist_id' => 'required|integer',
            'therapist_plan_id' => 'required|integer',
            'rozmana_number' => 'required|integer',
            'price' => 'required|integer',
            'status' => ['required', Rule::in(ClientPlanStatusEnum::values())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['status' => ClientPlanStatusEnum::PENDING->value]);
    }
}
