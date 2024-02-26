<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TherapistScheduleException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    public function __construct($message = "")
    {
        parent::__construct($message ?: __('app.therapists.schedules.therapist_schedule_exception_profile_data_not_completed'));

    }
}
