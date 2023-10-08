<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Http\Resources\ClientResource;
use App\Services\AuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService,public UserService $userService)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            if (isset($request->fcm_token))
                $this->userService->setUserFcmToken($user,$request->fcm_token);
            $token = $user->getToken();
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user'=>new ClientResource($user)
            ];
            return apiResponse(data: $data);
        } catch (NotFoundException $e) {
            return apiResponse($e->getMessage(), $e->getMessage(), code: 422);
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
        $user = auth()->user() ;
        $this->userService->setUserFcmToken($user , $request->fcm_token);
        return apiResponse(message: trans('lang.success_operation'));
    }


}
