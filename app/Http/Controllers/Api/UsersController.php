<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Http\Resources\ClientResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
