<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneVerifyRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Support\Facades\Mail;

class PhoneVerifyController extends Controller
{
    public function __invoke(PhoneVerifyRequest $request, PasswordResetCode $passwordResetCode)
    {
        try {
            $passwordResetCode->where('phone', $request->identifier)->delete();
            // Create a new code
            $codeData = $passwordResetCode->create($request->data());
            $token = User::query()->where('phone',$request->phone)->pluck('device_token')->toArray();
            if($codeData)
            {
                $title = 'Your OTP Code';
                $body = $codeData->code;
                app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $token);
                return apiResponse(message: __('lang.code_send_successfully'));
            }
            return apiResponse(message: 'there is an error please try again later',code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }

    }
}
