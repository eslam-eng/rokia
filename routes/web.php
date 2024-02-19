<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Invoice\InvoicesController;
use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\Report\LectureReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RozmanaController;
use App\Http\Controllers\SetLanguageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\Therapist\Lecture\LectureController;
use App\Http\Controllers\Therapist\TherapistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
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
Route::get('/', DashboardController::class)->name('/')->middleware(['auth', 'locale']);
//auth routes
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'locale']], function () {

    Route::get('local/{locale}', SetLanguageController::class)->name('language.change');

    Route::get('/', DashboardController::class)->name('home');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('clients', ClientController::class);
    Route::post('clients/{id}/status', [ClientController::class, 'status'])->name('clients.status');

    Route::resource('users', UserController::class);
    Route::post('users/{id}/status', [UserController::class, 'status'])->name('users.status');


    Route::resource('therapists', TherapistController::class)->except(['create']);
    Route::post('therapist/{id}/status', [TherapistController::class, 'status'])->name('therapist.status');

    Route::resource('sliders', SliderController::class);
    Route::post('sliders/{id}/status', [SliderController::class, 'status'])->name('sliders.status');

    Route::resource('therapist-lectures', LectureController::class);
    Route::post('therapist-lectures/{id}/status', [LectureController::class, 'status'])->name('therapist-lectures.status');

    Route::group(['prefix' => 'invoices'],function (){
        Route::get('/', [InvoicesController::class, 'index'])->name('invoices.index');
        Route::get('/{invoice}', [InvoicesController::class, 'show'])->name('invoices.show');
        Route::post('/{id}/status', [InvoicesController::class, 'completeInvoice'])->name('invoices.status');
    });

    Route::group(['prefix' => 'media'], function () {
        Route::delete('id', [MediaController::class, 'deleteMedia'])->name('delete-media');
    });
    Route::get('therapist-invoice/{invoice_number}',[InvoicesController::class,'therapistInvoice']);
    Route::get('therapists-rozmana', [RozmanaController::class,'index'])->name('therapists-rozmana');
    Route::get('therapists-rozmana/{therapist_id}', [RozmanaController::class,'show'])->name('therapists-rozmana.show');

    Route::group(['prefix' => 'search'],function (){
        Route::get('users',[ClientController::class,'search'])->name('users.search');
        Route::get('therapists',[TherapistController::class,'search'])->name('therapists.search');
    });

    Route::group(['prefix' => 'report'],function (){
        Route::get('lecture', LectureReportController::class)->name('lecture-report');
    });

    Route::resource('categories', CategoryController::class);
    Route::resource('specialists', SpecialistController::class);
    Route::post('categories/{id}/status', [CategoryController::class, 'status'])->name('categories.status');
    Route::post('specialists/{id}/status', [CategoryController::class, 'status'])->name('specialists.status');

    Route::get('settings', SettingsController::class)->name('settings.index');
    Route::group(['prefix' => 'admin'],function (){
        Route::resource('role', RoleController::class);
    });
    // Route::get('switcherpage', Switcherpage::class)->name('switcherpage');

});

Route::fallback(function () {
    return view('layouts.dashboard.error-pages.error404');
});
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

Route::get('/migrate-fresh/{password}', function ($password) {
    if ($password == 150024) {

        Artisan::call('migrate:fresh --seed');
        return "migrate fresh success";
    }
})->name('migrate-fresh');

Route::get('/migrate', function () {
    $output = Artisan::call('migrate');
    return '<pre>' . $output . '</pre>';
});

Route::get('/seed/{class_name}', function ($class_name) {
    $output = Artisan::call("db:seed --class=$class_name");
    return '<pre>' . $output . '</pre>';
});




