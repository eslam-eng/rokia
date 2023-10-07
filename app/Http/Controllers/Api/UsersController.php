<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Http\Requests\Users\ClientRequest;
use App\Services\UserService;
use Illuminate\Support\Arr;
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
            $this->userService->setUserFcmToken($tokenRequest->fcm_token);
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


}
