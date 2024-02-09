<?php

use App\Enums\UsersType;
use App\Http\Controllers\Api\Auth\AuthClientController;
use App\Http\Controllers\Api\Auth\AuthTherapistController;
use App\Http\Controllers\Api\Lecture\LectureController;
use App\Http\Controllers\Api\Lecture\UserLectureController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RozmanaController;
use App\Http\Controllers\Api\Slider\SliderController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\Wishlist\WishlistController;
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


Route::group(['prefix' => 'auth/therapist'], function () {

    Route::post('register', [AuthTherapistController::class, 'register']);

    Route::post('login', [AuthTherapistController::class, 'signIn']);

    Route::post('phone/verify', [AuthTherapistController::class,'phoneVerify']);
    Route::post('password/reset', [AuthTherapistController::class,'resetPassword']);

});


Route::group(['middleware' => 'auth:api_therapist'], function () {

    Route::group(['prefix' => 'therapist'], function () {

        Route::get('profile', [AuthTherapistController::class, 'getProfileDetails']);

        Route::post('update-fcm-token', [UsersController::class, 'updateFcmToken']);
        Route::post('/change-password', [UsersController::class, 'changePassword']);
        Route::post('/change-image', [UsersController::class, 'changeImage']);

        Route::apiResource('lectures', LectureController::class);
        Route::post('live-lectures', [LectureController::class, 'storeLiveLecture'])->name('live-lectures');
        Route::post('lectures/{id}/media', [LectureController::class, 'updateImageCover']);
        Route::post('send-notifications', [NotificationController::class, 'sendTherapistFcmNotification']);

        Route::group(['prefix' => 'notifications'], function () {
            Route::post('/send', [NotificationController::class, 'sendFcmNotification']);
            Route::get('/', [NotificationController::class, 'getNotifications']);
            Route::get('/{notification_id}/mark-as-read', [NotificationController::class, 'markAsRead']);
        });

        Route::group(['prefix' => 'media'], function () {
            Route::delete('{id}', [MediaController::class, 'deleteMedia']);
        });

        Route::apiResource('rozmana', RozmanaController::class);

    });

});

