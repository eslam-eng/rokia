<?php

use Carbon\Carbon;
use Illuminate\Support\Arr;

if (!function_exists('apiResponse')) {
    function apiResponse($data = null, $message = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'status' => in_array($code, successCode()),
            'message' => $message,
        ];
        return response($array, $code);
    }
}

if (!function_exists('successCode')) {
    function successCode(): array
    {
        return [
            200, 201, 202
        ];
    }
}

if (!function_exists('notifyUser')) {

    function notifyUser(\App\Models\User $user, $data = [])
    {
        $user->notify(new \App\Notifications\GeneralNotification($data));
    }
}

if (!function_exists('getLocale')) {

    function getLocale(): string
    {
        return app()->getLocale();
    }
}


if (!function_exists('setLanguage')) {

    function setLanguage(string $locale): void
    {
        app()->setLocale($locale);
    }
}

if (!function_exists('getAuthUser')) {

    function getAuthUser(string $guard = 'sanctum'): \Illuminate\Contracts\Auth\Authenticatable|null|\App\Models\User
    {
        return auth($guard)->user();
    }
}


if (!function_exists('authUserHasPermission')) {

    function authUserHasPermission(string $permission_name): bool
    {
        return auth()->user()->can($permission_name);
    }
}
if (!function_exists('transformValidationErrors')) {

    function transformValidationErrors(array $errors)
    {
        return collect($errors)->map(function ($error, $key) {
            return [
                "key" => $key,
                "error" => Arr::first($error),
            ];
        })->values()->toArray();
    }
}
if (!function_exists('timeTransformer')) {

    function timeTransformer($start_time, $end_time, $interval_time): array
    {

        $start_time = Carbon::createFromTimeString("$start_time");
        $end_time = Carbon::createFromTimeString("$end_time");
        $dividedPeriod = [];

        // Start from the beginning of the period
        $current = clone $start_time;

        // Iterate through the period
        while ($current < $end_time) {
            // Check if the current time falls within the specified range
            if ($current >= $start_time && $current < $end_time) {
                $dividedPeriod[] = $current->format('h:i A');
            }

            // Move to the next interval
            $current->addMinutes($interval_time);
        }

        return $dividedPeriod;

    }
}

