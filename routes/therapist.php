<?php

use App\Http\Controllers\Api\Appointment\BookAppointmentController;
use App\Http\Controllers\Api\Auth\AuthTherapistController;
use App\Http\Controllers\Api\Category\InterestsController;
use App\Http\Controllers\Api\Invoice\InvoicesController;
use App\Http\Controllers\Api\Lecture\LectureController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Plans\TherapistPlansController;
use App\Http\Controllers\Api\RozmanaController;
use App\Http\Controllers\Api\Slider\SliderController;
use App\Http\Controllers\Api\Specialist\SpecialistController;
use App\Http\Controllers\Api\Therapist\TherapistController;
use App\Http\Controllers\Api\TherapistSchedule\TherapistScheduleController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Media\MediaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::fallback(function () {
    return apiResponse(message: 'Invalid Route', code: 404);
});

Route::group(['middleware' => 'locale'],function (){
    Route::group(['prefix' => 'auth/therapist'], function () {

        Route::post('register', [AuthTherapistController::class, 'register']);

        Route::post('login', [AuthTherapistController::class, 'signIn']);

        Route::post('phone/verify', [AuthTherapistController::class, 'phoneVerify']);
        Route::post('password/reset', [AuthTherapistController::class, 'resetPassword']);

    });


    Route::group(['middleware' => 'auth:api_therapist'], function () {

        Route::group(['prefix' => 'therapist'], function () {


            Route::post('update-fcm-token', [UsersController::class, 'updateFcmToken']);
            Route::post('/change-password', [UsersController::class, 'changePassword']);
            Route::post('/change-image', [UsersController::class, 'changeImage']);

            Route::get('profile', [TherapistController::class, 'getProfileDetails']);
            Route::post('update-data', [TherapistController::class, 'updateProfileData']);
            Route::post('update-therapy-data', [TherapistController::class, 'updateTherapyData']);

            Route::group(['prefix' => 'schedule'],function (){
                Route::get('/', [TherapistScheduleController::class, 'index']);
                Route::get('days', [TherapistScheduleController::class, 'getDays']);
                Route::post('/', [TherapistScheduleController::class, 'store']);
                Route::delete('{therapist_schedule}', [TherapistScheduleController::class, 'destroy']);

            });


            Route::apiResource('lectures', LectureController::class);
            Route::post('live-lectures', [LectureController::class, 'storeLiveLecture'])->name('live-lectures');
            Route::post('lectures/{id}/media', [LectureController::class, 'updateImageCover']);
            Route::post('send-notifications', [NotificationController::class, 'sendTherapistFcmNotification']);


            Route::group(['prefix' => 'media'], function () {
                Route::delete('{id}', [MediaController::class, 'deleteMedia']);
            });

            Route::apiResource('rozmana', RozmanaController::class);
            Route::get('specialists', SpecialistController::class);

            Route::apiResource('plans', TherapistPlansController::class);
            Route::post('plans/{id}/status', [TherapistPlansController::class, 'changeStatus']);

            Route::apiResource('booked-appointments', BookAppointmentController::class)->only('index');

            Route::apiResource('invoices', InvoicesController::class);
            Route::get('interests', InterestsController::class);

            Route::group(['prefix' => 'booked-appointments/{book_appointment}'],function (){
                Route::post('approve',[BookAppointmentController::class, 'changeToWaitingForPaid']);
                Route::post('cancel',[BookAppointmentController::class,'changeToCanceled']);
                Route::post('compelete',[BookAppointmentController::class, 'changeToCompleted']);

            });
        });
    });

});
