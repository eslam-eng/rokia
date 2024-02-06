<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\PushNotificationRequest;
use App\Http\Resources\NotificationsResource;
use App\Services\LectureService;
use App\Services\PushNotificationService;
use App\Services\UserService;


class NotificationController extends Controller
{
    public function __construct(protected PushNotificationService $pushNotificationService, protected LectureService $lectureService, protected UserService $userService)
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
