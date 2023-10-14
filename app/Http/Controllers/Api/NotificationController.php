<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\PushNotificationRequest;
use App\Http\Resources\NotificationsResource;
use App\Models\Lecture;
use App\Models\User;
use App\Services\PushNotificationService;


class NotificationController extends Controller
{
    public function __construct(protected PushNotificationService $pushNotificationService)
    {
    }

    public function getNotifications()
    {
        try {
            $notifications = $this->pushNotificationService->getUserNotifications();
            return NotificationsResource::collection($notifications);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 400);
        }
    }

    public function markAsRead(int $notification_id)
    {
        try {
            $this->pushNotificationService->markAsRead($notification_id);
            return apiResponse();
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error', code: 400);
        }
    }

    public function sendTherapistFcmNotification(PushNotificationRequest $request)
    {
        try {
            $auth_user_id = auth()->id();
            $users_ids = Lecture::query()->join('user_lectures', 'user_lectures.lecture_id', '=', 'lectures.id')->select('user_lectures.user_id')->where('therapist_id', $auth_user_id)->pluck('user_lectures.user_id')->toArray();
            $deviceTokens = User::query()->whereIntegerInRaw('id', $users_ids)->pluck('device_token')->toArray();
            $this->pushNotificationService->sendToTokens(title: $request->title, body: $request->body, tokens: $deviceTokens);
            return apiResponse(message: 'notification send to users successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error try again later', code: 500);
        }
    }
}
