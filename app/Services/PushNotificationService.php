<?php

namespace App\Services;


use App\Exceptions\NotFoundException;

class PushNotificationService extends BaseService
{

    public function getUserNotifications()
    {
        $user = getAuthUser();
        return $user->notifications()->orderByDesc('id')->cursorPaginate(20);
    }

    public function unReadCount($auth_user_id)
    {
        $user  = getAuthUser();;
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

}
