<?php

namespace App\Services;


use App\Exceptions\NotFoundException;
use App\Models\Therapist;
use App\Models\User;
use FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NotificationService extends BaseService
{

    public function getUserNotifications(User|Therapist $user): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $user->notifications()->orderByDesc('id')->cursorPaginate(20);
    }

    public function getUserNotificationsCount(User|Therapist $user): int
    {
        return $user->notifications()->whereNull('read_at')->count();
    }

    public function unReadCount($auth_user_id)
    {
        $user = getAuthUser();;
        return $user->notifications()->whereNull('read_at')->count();
    }

    /**
     * @throws NotFoundException
     */
    public function markAsRead($notification_id)
    {
        $user = getAuthUser();
        $user->notifications->where('id', $notification_id)->markAsRead();
    }

    public function markAllAsRead(User|Therapist $user)
    {
        $user->notifications()->update(['read_at'=>now()]);
    }

    public function sendToTokens(string $title, string $body, $tokens = [], $data = [])
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

       return $downstreamResponse;
    }
}
