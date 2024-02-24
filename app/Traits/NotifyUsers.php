<?php

namespace App\Traits;

use App\Models\User;
use App\Services\NotificationService;

trait NotifyUsers
{
    public function notifyUsers($title, $content)
    {
        $usersTokens = User::query()->pluck('device_token')->toArray();
        $usersTokens = array_filter($usersTokens);
        if (count($usersTokens)) {
            app()->make(NotificationService::class)->sendToTokens($title, $content, $usersTokens);
        }
    }

}
