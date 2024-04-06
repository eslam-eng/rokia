<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:show_setting']);
    }
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    
    public function __invoke(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('settings.index');
    }
}
