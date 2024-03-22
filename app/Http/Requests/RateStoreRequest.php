<?php

namespace App\Http\Requests;

use App\Enums\RateType;
use Illuminate\Foundation\Http\FormRequest;

class RateStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
      
            'relatable_id' => 'required|integer',
            'relatable_type' =>'required|string|in:' . implode(',', RateType::values()),
            'rate_number' => 'required|integer',
            'comment' => 'required|string',
        ];
    }
}
