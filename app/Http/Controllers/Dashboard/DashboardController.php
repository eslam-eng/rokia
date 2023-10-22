<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * Change the password
     *
     * @param mixed $request
     */
    public function __invoke()
    {
        $data = DashboardService::statistics();
        return view('layouts.dashboard.home',compact('data'));
    }
}
