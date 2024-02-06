<?php

use App\Enums\UsersType;
use App\Http\Controllers\Api\Auth\AuthClientController;
use App\Http\Controllers\Api\Lecture\LectureController;
use App\Http\Controllers\Api\Lecture\UserLectureController;
use App\Http\Controllers\Api\NotificationController;
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

Route::group(['prefix' => 'auth/client'], function () {

    Route::post('register', [AuthClientController::class, 'register']);

    Route::post('login', [AuthClientController::class, 'signIn']);

    Route::post('phone/verify', [AuthClientController::class, 'phoneVerify']);

    Route::post('password/reset', [AuthClientController::class, 'resetPassword']);

});


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'client'], function () {
        Route::get('profile', [AuthClientController::class, 'getProfileDetails']);
        Route::post('update-fcm-token', [UsersController::class, 'updateFcmToken']);
        Route::post('/change-password', [UsersController::class, 'changePassword']);
        Route::post('/change-image', [UsersController::class, 'changeImage']);
    });

    Route::group(['middleware' => 'user.type:' . UsersType::CLIENT->value], function () {
        Route::get('lectures', [LectureController::class, 'getLecturesForUser']);
        Route::group(['prefix' => 'client'], function () {
            Route::get('lectures', UserLectureController::class);
            Route::apiResource('wishlist', WishlistController::class);
            Route::delete('wishlist/lecture/{id}/remove', [WishlistController::class, 'removeLectureFormFavorite']);
        });
    });


    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [NotificationController::class, 'getNotifications']);
        Route::get('/{notification_id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    });

    Route::group(['prefix' => 'media'], function () {
        Route::delete('{id}', [MediaController::class, 'deleteMedia']);
    });

    Route::get('sliders', SliderController::class);

});

