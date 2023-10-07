<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwbController;
use App\Http\Controllers\AwbHistoryController;
use App\Http\Controllers\AwbStatusController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ImportLogsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\PriceTableController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\Therapist\TherapistController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'authentication', 'middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('signin');
});
Route::get('/', function () {
    return view('layouts.dashboard.home');
})->name('/')->middleware('auth');
//auth routes
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    Route::get('/', function () {
        return view('layouts.dashboard.home');
    })->name('home');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('users', UsersController::class);
    Route::resource('therapists', TherapistController::class);
    Route::post('therapist/{id}/status',[TherapistController::class,'status'])->name('therapist.status');
    Route::delete('therapist/{id}/media/{media_id}',[TherapistController::class,'deleteMedia'])->name('therapist.delete-media');
      // Route::get('switcherpage', Switcherpage::class)->name('switcherpage');

});

Route::fallback(function () {
    return view('layouts.dashboard.error-pages.error404');
});
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');
Route::get('/migrate-fresh/{password}', function ($password) {
    if ($password == 150024) {

        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
        return "migrate fresh success";
    }
})->name('migrate-fresh');




