<?php

namespace App\Http\Controllers\Api\Auth;

use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PhoneVerifyRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\Users\ThereapistRequest;
use App\Services\Therapist\TherapistService;
use App\Services\UserService;
use Exception;
use Illuminate\Validation\ValidationException;

class AuthTherapistController extends Controller
{
    public function __construct(protected TherapistService $therapistService, private UserService $userService)
    {
    }

    public function signIn(LoginRequest $request)
    {
        try {
            $therapist = $this->therapistService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            if ($therapist->status == ActivationStatus::PENDING->value)
                return apiResponse(message: __('app.auth.auth_in_review'), code: 422);
            if (isset($request->fcm_token))
                $this->userService->setUserFcmToken(user: $therapist, fcm_token: $request->fcm_token);
            $token = $therapist->getToken();
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
//                'therapist' => new TherapistResource($therapist)
            ];
            return apiResponse(data: $data);
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse($e->getMessage(), 'there is an error please try again later', code: 422);
        }
    }

    public function register(ThereapistRequest $request)
    {
        try {
            $therapistDTO = CreateTherapistDTO::fromRequest($request);
            $this->therapistService->store($therapistDTO);
            return apiResponse(message: __('app.auth.auth_in_review'));
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        } catch (\Exception $exception) {
            return apiResponse(message: 'Something Went Wrong', code: 500);
        }
    }

    public function phoneVerify(PhoneVerifyRequest $request)
    {
        try {
            $user_type = UsersType::THERAPIST->value;
            $code = $this->userService->phoneVerifyAndSendFcm(phone: $request->phone, user_type: $user_type);
            return apiResponse(data: $code, message: 'code sent to phone number');
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        } catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user_type = UsersType::THERAPIST->value;
        $is_password_updated = $this->userService->resetPassword(code: $request->code, password: $request->password, user_type: $user_type);
        if ($is_password_updated)
            return apiResponse(message: 'password updated successfully');
        return apiResponse(message: 'there is an error please try again later', code: 422);
    }

}
