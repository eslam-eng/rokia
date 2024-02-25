<?php

namespace App\Http\Controllers\Api\Appointment;

use App\DataTransferObjects\BookAppointment\BookAppointmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookAppointment\BookAppointmentRequest;
use App\Services\Appointment\BookAppointmentService;
use App\Services\TherapistService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookAppointmentController extends Controller
{
    public function __construct(protected BookAppointmentService $bookAppointmentService,public TherapistService $therapistService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->all(), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

    }

    public function store(BookAppointmentRequest $request)
    {
        try {
            $bookAppointmentDTO = BookAppointmentDTO::fromRequest($request);
            $therapist = $this->therapistService->findById(id: $bookAppointmentDTO->therapist_id);
            $bookAppointmentDTO->therapy_price = $therapist->therapy_price;
            $bookAppointmentDTO->client_id = auth()->id();
            $this->bookAppointmentService->store(bookAppointmentDTO: $bookAppointmentDTO);
            return apiResponse(message: __('app.book_appointments.created_successully_will_review'));
        } catch (\Exception $exception) {
            return apiResponse(message:$exception->getMessage(),code: 500);
        }
    }

}
