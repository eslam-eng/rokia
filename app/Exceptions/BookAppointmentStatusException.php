<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class BookAppointmentStatusException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    public function __construct(protected $status,$message = "")
    {
        parent::__construct($message ?: __('app.appointments.appointment_status_change_exception', ['status' => $status]));

    }
}
