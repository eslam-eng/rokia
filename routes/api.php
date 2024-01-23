<?php

use App\Enums\UsersType;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Lecture\LectureController;
use App\Http\Controllers\Api\Lecture\UserLectureController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\Slider\SliderController;
use App\Http\Controllers\Api\Therapist\TherapistController;
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

Route::group(['prefix' => 'auth'], function () {

    Route::post('user/register', [UsersController::class, 'store']);

    Route::post('therapist/register', [TherapistController::class, 'store']);

    Route::post('login', [AuthController::class, 'login']);

    Route::post('phone/verify', PhoneVerifyController::class);

//    Route::post('password/forget', PhoneVerifyController::class);

    Route::post('password/reset', RestPasswordController::class);

});


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'user'], function () {

        Route::post('set-fcm-token', [AuthController::class, 'setFcmToken']);

        Route::patch('user', [AuthController::class, 'update']);

        Route::get('profile', [UsersController::class, 'getProfileDetails']);

        Route::post('/change-password', [UsersController::class, 'changePassword']);

    });

    Route::group(['prefix' => 'therapist'], function () {
        Route::apiResource('lectures', LectureController::class);
        Route::middleware('user.type:' . UsersType::THERAPIST->value)->group(function () {
            Route::post('live-lectures', [LectureController::class, 'storeLiveLecture'])->name('live-lectures');
            Route::post('lectures/{id}/media', [LectureController::class, 'updateImageCover']);
            Route::post('send-notifications', [NotificationController::class, 'sendTherapistFcmNotification']);

        });
    });

    Route::group(['prefix' => 'client', 'middleware' => 'user.type:' . UsersType::CLIENT->value], function () {
        Route::get('lectures', UserLectureController::class);
        Route::apiResource('wishlist', WishlistController::class);
        Route::delete('wishlist/lecture/{id}/remove', [WishlistController::class, 'removeLectureFormFavorite']);
    });

    Route::post('update-device-token', [UsersController::class, 'updateDeviceToken']);

    Route::group(['prefix' => 'notifications'], function () {
        Route::post('/send', [NotificationController::class, 'sendFcmNotification']);
        Route::get('/', [NotificationController::class, 'getNotifications']);
        Route::get('/{notification_id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    });

    Route::group(['prefix' => 'media'], function () {
        Route::delete('{id}', [MediaController::class, 'deleteMedia']);
    });

    Route::get('sliders', SliderController::class);

});

