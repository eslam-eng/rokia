<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Notification\StoreFcmTokenRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function loginForm()
    {
        return view('layouts.dashboard.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            $toast = [
                'type' => 'success',
                'title' => 'success',
                'message' => trans('app.login_successfully')
            ];
            if (isset($request->fcm_token))
                $this->authService->setUserFcmToken($user,$request->fcm_token);
            return to_route('home')->with('toast', $toast);
        } catch (NotFoundException $e) {
            return back()->with('error', "email or password incorrect please try again");
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }

    public function setFcmToken(StoreFcmTokenRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = auth()->user();
        $this->authService->setUserFcmToken($user, $request->fcm_token);
        return apiResponse(message: trans('lang.success_operation'));
    }
}
