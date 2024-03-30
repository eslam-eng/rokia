<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\PushNotificationRequest;
use App\Http\Resources\NotificationsResource;
use App\Services\LectureService;
use App\Services\NotificationService;
use App\Services\UserService;


class NotificationController extends Controller
{
    public function __construct(protected NotificationService $pushNotificationService, protected LectureService $lectureService, protected UserService $userService)
    {
    }

    public function getNotifications()
    {
        try {
            if (auth()->guard('api_therapist')->check())
                $user = auth()->guard('api_therapist')->user();
            else
                $user = auth()->user();

            $notifications = $this->pushNotificationService->getUserNotifications(user: $user);
            return NotificationsResource::collection($notifications);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 400);
        }
    }

    public function getNotificationsCount()
    {
        try {
            if (auth()->guard('api_therapist')->check())
                $user = auth()->guard('api_therapist')->user();
            else
                $user = auth()->user();
            $notificationsCount = $this->pushNotificationService->getUserNotificationsCount(user: $user);
            return apiResponse(data: ['notifications_count' => $notificationsCount], message: __('app.general.success_operation'));
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
            return apiResponse(message: 'there is an error', code: 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            if (auth()->guard('api_therapist')->check())
                $user = auth()->guard('api_therapist')->user();
            else
                $user = auth()->user();
            $this->pushNotificationService->markAllAsRead($user);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error', code: 500);
        }
    }

    //for therapist
    public function sendFcmNotification(PushNotificationRequest $request)
    {
        try {
            $auth_therapist_id = auth()->guard('therapist')->id();
            $users_ids = $this->lectureService->getSubscribedUsersForTherapist($auth_therapist_id);
            $deviceTokens = $this->userService->getDeviceTokenForUsers($users_ids);
            $this->pushNotificationService->sendToTokens(title: $request->title, body: $request->body, tokens: $deviceTokens);
            return apiResponse(message: 'notification send to users successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error try again later', code: 500);
        }
    }
}
