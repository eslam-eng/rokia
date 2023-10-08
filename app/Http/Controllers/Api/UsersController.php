<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ChangePassword\PasswordChangeDTO;
use App\DataTransferObjects\User\UserDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Http\Requests\Users\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function __construct(public UserService $userService)
    {
    }

    public function updateDeviceToken(StoreFcmTokenRequest $tokenRequest)
    {
        try {
            $user = getAuthUser();
            $this->userService->setUserFcmToken($tokenRequest->fcm_token, $user);
            return apiResponse(message: 'token updated_successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error');
        }
    }

    public function store(ClientRequest $request)
    {
        try {
            DB::beginTransaction();
            $userDTO = UserDTO::fromRequest($request);
            $this->userService->store($userDTO);
            DB::commit();
            return apiResponse(message: 'user registered successfully');
        } catch (ValidationException $exception) {
            DB::rollBack();
            $mappedErrors = collect($exception->errors())->map(function ($error, $key) {
                return [
                    "key" => $key,
                    "error" => Arr::first($error),
                ];
            })->values()->toArray();
            return response(['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], 422);
        } catch (\Exception $exception) {
            DB::rollBack();
            return apiResponse(message: 'Something Went Wrong', code: 500);
        }
    }

    public function getProfileDetails()
    {
        try {
            $user = getAuthUser();
            return apiResponse(data: ClientResource::make($user), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $user = getAuthUser();
            $passwordChangeDTO = PasswordChangeDTO::fromRequest($request);
            $is_changed = $this->userService->changePassword($user, $passwordChangeDTO);
            if ($is_changed)
                return apiResponse(message: trans('app.success_operation'));
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (\Exception $e) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }


    public function changeImage(ImageUploadRequest $request)
    {
        try {
            $user = getAuthUser();
            $user = $this->userService->changeImage($user, $request->file);
            return apiResponse(data: ClientResource::make($user), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }

    public function deactivateAccount()
    {
        try {
            $user = getAuthUser();
            $user->status = !$user->status ;
            $user->save();
            Auth::user()->tokens()->delete();
            return apiResponse(data: ClientResource::make($user), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: 'something went wrong', code: 500);
        }
    }

}
