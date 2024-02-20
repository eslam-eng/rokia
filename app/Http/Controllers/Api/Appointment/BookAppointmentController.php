<?php

namespace App\Http\Controllers\Api\Appointment;

use App\DataTransferObjects\BookAppointment\BookAppointmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookAppointment\BookAppointmentRequest;
use App\Services\Appointment\BookAppointmentService;
use Illuminate\Http\Request;

class BookAppointmentController extends Controller
{
    public function __construct(protected BookAppointmentService $bookAppointmentService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

    }

    public function store(BookAppointmentRequest $request)
    {
        try {
            $bookAppointmentDTO = BookAppointmentDTO::fromRequest($request);
            $bookAppointmentDTO->client_id = auth()->id();
            $this->bookAppointmentService->store(bookAppointmentDTO: $bookAppointmentDTO);
            return apiResponse(message: __('app.book_appointments.created_successully_will_review'));
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => 'Success', 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }

    }

}
