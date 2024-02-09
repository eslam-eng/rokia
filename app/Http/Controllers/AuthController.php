<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function loginForm()
    {
        return view('layouts.dashboard.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $this->userService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            $toast = [
                'type' => 'success',
                'title' => 'success',
                'message' => trans('app.login_successfully')
            ];
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
}
