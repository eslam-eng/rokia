<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivationStatus;
use App\Enums\UsersType;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Http\Resources\ClientResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService, public UserService $userService)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            if (isset($request->fcm_token))
                $this->userService->setUserFcmToken(fcm_token: $request->fcm_token, user: $user);

            if ($user->status == ActivationStatus::PENDING->value)
                return apiResponse(message: __('app.auth.auth_in_review'),code: 422);

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

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return apiResponse(message: __('lang.logout_success'));
    }

    public function setFcmToken(StoreFcmTokenRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = getAuthUser();
        $this->userService->setUserFcmToken(fcm_token: $request->fcm_token, user: $user);
        return apiResponse(message: trans('lang.success_operation'));
    }
}
