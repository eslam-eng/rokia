<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PhoneVerifyRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => ['required',Rule::exists('users','phone')]
        ];
    }

    /**
     * the data of above request
     *
     * @return array
     */
    public function data()
    {
        return [
            'phone' => request()->phone,
            'code' => mt_rand(100000, 999999),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
