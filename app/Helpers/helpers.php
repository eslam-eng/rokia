<?php

use App\Models\Therapist;
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

    function timeTransformer(string $start_time, string $end_time,int $day_id,Therapist $therapist): array
    {

        $interval_time = $therapist->avg_therapy_duration;
        $start_time = Carbon::createFromTimeString("$start_time");
        $end_time = Carbon::createFromTimeString("$end_time");
        $dividedPeriod = [];

        // Start from the beginning of the period
        $current = clone $start_time;

        // Iterate through the period
        while ($current < $end_time) {
            // Check if the current time falls within the specified rangeW
            if ($current >= $start_time && $current < $end_time) {
                $dividedPeriod[] = $current->format('h:i A');
            }

            // Move to the next interval
            $current->addMinutes($interval_time);
        }
        $bookedAppointments = $therapist->appointments->whereDate('date','>=',Carbon::now())
            ->where('day_id',$day_id)
            ->where('status','!=',\App\Enums\BookAppointmentStatusEnum::COMPOLETED->value)
            ->pluck('time')
            ->toArray();

        return array_diff($dividedPeriod, $bookedAppointments);


    }
}

if (!function_exists('getDateForBookAppointment')) {

    function getDateForBookAppointment(int $day_id, string $appointment_time): string
    {
        // Get the current date
        $currentDate = Carbon::now();
        // Calculate the future date based on the day index
        $futureDate = $currentDate->startOfWeek()->next($day_id);
        // Convert the appointment time to hours and minutes
        list($hours, $minutes) = explode(':', $appointment_time);

        // Set the appointment time on the future date
        $appointmentDateTime = $futureDate->setTime($hours, $minutes);

        // Format the appointment date/time as needed
        return  $appointmentDateTime->format('Y-m-d H:i:s');
    }
}

