<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Invoice\InvoicesController;
use App\Http\Controllers\Language\SetLanguageController;
use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\Therapist\Lecture\LectureController;
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
Route::get('/', DashboardController::class)->name('/')->middleware(['auth','locale']);
//auth routes
Route::group(['prefix' => 'dashboard', 'middleware' =>['auth','locale']], function () {

    Route::get('local/{locale}', SetLanguageController::class)->name('language.change');

    Route::get('/', DashboardController::class)->name('home');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('users', UsersController::class);

    Route::resource('therapists', TherapistController::class)->except(['create']);
    Route::post('therapist/{id}/status', [TherapistController::class, 'status'])->name('therapist.status');

    Route::resource('therapist-lectures', LectureController::class);
    Route::post('therapist-lectures/{id}/status', [LectureController::class, 'status'])->name('therapist-lectures.status');

    Route::get('invoices', [InvoicesController::class,'index'])->name('invoices.index');
    Route::get('invoices/{id}', [InvoicesController::class,'show'])->name('invoices.show');

    Route::group(['prefix' => 'media'], function () {
        Route::delete('id', [MediaController::class, 'deleteMedia'])->name('delete-media');
    });
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




