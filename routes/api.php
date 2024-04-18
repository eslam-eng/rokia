<?php

use App\Enums\UsersType;
use App\Http\Controllers\Api\Appointment\BookAppointmentController;
use App\Http\Controllers\Api\Auth\AuthClientController;
use App\Http\Controllers\Api\Lecture\LectureController;
use App\Http\Controllers\Api\Lecture\UserLectureController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Plans\ClientPlansSubscriptionController;
use App\Http\Controllers\Api\Plans\TherapistPlansController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\Slider\SliderController;
use App\Http\Controllers\Api\Therapist\TherapistController;
use App\Http\Controllers\Api\TherapistSchedule\TherapistScheduleController;
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
Route::group(['middleware' => 'locale'],function (){
    Route::group(['prefix' => 'auth/client'], function () {
        Route::post('register', [AuthClientController::class, 'register']);
        Route::post('login', [AuthClientController::class, 'signIn']);
        Route::post('phone/verify', [AuthClientController::class, 'phoneVerify']);
        Route::post('password/reset', [AuthClientController::class, 'resetPassword']);
    });

    Route::group(['middleware' => ['auth:sanctum', 'user.type:' . UsersType::CLIENT->value]], function () {

        Route::get('lectures', [LectureController::class, 'getLecturesForUser']);

        Route::group(['prefix' => 'client'], function () {
            Route::get('profile', [AuthClientController::class, 'getProfileDetails']);
            Route::post('update-fcm-token', [UsersController::class, 'updateFcmToken']);
            Route::post('/change-password', [UsersController::class, 'changePassword']);
            Route::post('/change-image', [UsersController::class, 'changeImage']);
            Route::post('/update-data', [UsersController::class, 'updateProfileData']);

            Route::get('lectures', [UserLectureController::class, 'index']);
            Route::post('lectures', [UserLectureController::class, 'buyLecture']);
            Route::post('lecture/confirm-payment', [UserLectureController::class, 'confirmLecturePayment']);
            Route::apiResource('wishlist', WishlistController::class);
            Route::delete('wishlist/lecture/{id}/remove', [WishlistController::class, 'removeLectureFormFavorite']);
            Route::apiResource('book-appointment', BookAppointmentController::class);
            Route::post('booked-appointments/{book_appointment}/cancel', [BookAppointmentController::class, 'changeToCanceled']);
            Route::post('booked-appointments/confirm-payment', [BookAppointmentController::class, 'confirmBookAppointmentPayment']);

            Route::post('plan-subscribe', [ClientPlansSubscriptionController::class, 'subscribe']);
            Route::post('plan-subscribe/confirm-payment', [ClientPlansSubscriptionController::class, 'confirmSubscribePlanPayment']);
            Route::get('plans', [ClientPlansSubscriptionController::class, 'getPlansForUser']);
        });


        Route::group(['prefix' => 'media'], function () {
            Route::delete('{id}', [MediaController::class, 'deleteMedia']);
        });

        Route::get('plans', [TherapistPlansController::class, 'getPlansForClients']);
        Route::get('therapist/{therapist}/schedule', [TherapistScheduleController::class, 'getScheduleForTherapist']);
        Route::post('therapist/apointments/schedule', [TherapistScheduleController::class, 'getScheduleForTherapist']);
        Route::get('therapists', [TherapistController::class, 'index']);

        Route::apiResource('rates', RateController::class);
    });

//shared routes between therapists and clients
    Route::group(['middleware' => 'auth:sanctum'],function (){
        Route::get('sliders', SliderController::class);

        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', [NotificationController::class, 'getNotifications']);
            Route::get('/{notification_id}/mark-as-read', [NotificationController::class, 'markAsRead']);
            Route::get('mark-as-read', [NotificationController::class, 'markAllAsRead']);
            Route::get('count', [NotificationController::class, 'getNotificationsCount']);
        });
    });
});

