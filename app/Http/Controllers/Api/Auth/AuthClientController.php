<?php

namespace App\Http\Controllers\Api\Auth;

use App\DataTransferObjects\User\UserDTO;
use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PhoneVerifyRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\Users\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\PasswordResetCode;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthClientController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function signIn(LoginRequest $request)
    {
        try {
            $user = $this->login(request: $request);
            if ($user->status == ActivationStatus::PENDING->value)
                return apiResponse(message: __('app.auth.auth_in_review'), code: 422);
            $token = $user->getToken();
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new ClientResource($user)
            ];
            return apiResponse(data: $data);
        } catch (NotFoundException $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        } catch (Exception $e) {
            return apiResponse($e->getMessage(), 'there is an error please try again later', code: 422);
        }
    }

    public function register(ClientRequest $request)
    {
        try {
            DB::beginTransaction();
            $userDTO = UserDTO::fromRequest($request);
            $user = $this->userService->store($userDTO);
            DB::commit();
            $token = $user->getToken();
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new ClientResource($user)
            ];
            return apiResponse(data: $data);
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
            $therapist = Auth::user();
            return apiResponse(data: ClientResource::make($therapist), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }

    public function phoneVerify(PhoneVerifyRequest $request)
    {
        try {
            $user_type = UsersType::CLIENT->value;
            $this->userService->phoneVerifyAndSendFcm(phone: $request->phone,user_type: $user_type);
            return apiResponse(message:'code sent to phone number');
        }catch (NotFoundException $exception){
            return apiResponse(message: $exception->getMessage(),code: 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user_type = UsersType::CLIENT->value;
        $is_password_updated = $this->userService->resetPassword(code: $request->code,password: $request->password,user_type: $user_type);
        if ($is_password_updated)
            return apiResponse(message: 'password updated successfully');
        return apiResponse(message: 'there is an error please try again later',code: 422);
    }
}
