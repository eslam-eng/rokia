<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\DataTransferObjects\Client\UpdateClientDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeLanguage\ChangeLanguageRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Http\Resources\ClientResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function __construct(public UserService $userService)
    {
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            if (Auth::guard('therapist')->check())
                $user = Auth::guard('therapist')->user();
            else
                $user = Auth::user();
            $passwordChangeDTO = PasswordChangeDTO::fromRequest($request);
            $is_changed = $this->userService->changePassword($user, $passwordChangeDTO);
            if ($is_changed)
                return apiResponse(message: trans('app.password_updated_successfully'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (\Exception $e) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }

    public function changeImage(ImageUploadRequest $request)
    {
        try {
            if (Auth::guard('api_therapist')->check())
                $user = Auth::guard('api_therapist')->user();
            else
                $user = Auth::user();
            $this->userService->changeImage($user, $request->image);
            return apiResponse(message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }

    public function updateFcmToken(StoreFcmTokenRequest $request)
    {
        if (Auth::guard('therapist')->check())
            $user = Auth::guard('therapist')->user();
        else
            $user = Auth::user();
        $this->userService->setUserFcmToken(user: $user, fcm_token: $request->fcm_token);
        return apiResponse(message: trans('lang.success_operation'));
    }

    public function updateProfileData(ClientUpdateRequest $request)
    {
        try {
            $clientDTO = UpdateClientDTO::fromRequest($request);
            $client = auth()->user();
            $this->userService->updateClientData(clientId: $client->id, clientDTO:  $clientDTO);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return apiResponse(data: ['message' => __('app.general.invalid_inputs'), 'errors' => $mappedErrors], code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function changeLanguage(ChangeLanguageRequest $request)
    {
        if (auth()->guard('api_therapist')->check())
            $user = auth()->guard('api_therapist')->user();
        else
        $user = auth()->user();
        $lang = $request->lang;
        $this->userService->updateLanguage(user: $user,language: $lang);
        return apiResponse(message: __('app.general.success_operation'));


    }
}
