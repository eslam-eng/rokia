<?php

namespace App\Http\Requests;

class ImageUploadRequest extends BaseRequest
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
            'file' => 'required|file|mimes:png,jpg,jpeg',
        ];
    }
}
