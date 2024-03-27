<?php

namespace App\Http\Controllers\Api\Appointment;

use App\DataTransferObjects\BookAppointment\BookAppointmentDTO;
use App\Exceptions\BookAppointmentStatusException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookAppointment\BookAppointmentPaymentRequest;
use App\Http\Requests\BookAppointment\BookAppointmentRequest;
use App\Http\Requests\Payment\ConfirmPaymentRequest;
use App\Http\Resources\Appointments\BookAppointmentsResource;
use App\Models\BookAppointment;
use App\Services\Appointment\BookAppointmentService;
use App\Services\NotificationService;
use App\Services\Therapist\TherapistService;
use Illuminate\Http\Request;

class BookAppointmentController extends Controller
{
    public function __construct(
        protected BookAppointmentService       $bookAppointmentService,
        public TherapistService                $therapistService,
        protected readonly NotificationService $notificationService
    )
    {
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->all(), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        if (auth()->guard('api_therapist')->check())
            $filters['therapist_id'] = auth()->guard('api_therapist')->id();
        else
            $filters['client_id'] = auth()->id();
        return BookAppointmentsResource::collection($this->bookAppointmentService->paginate(filters: $filters));

    }

    public function store(BookAppointmentRequest $request)
    {
        try {
            //todo make validation that time inperiod that i store in therapist schedule
            $bookAppointmentDTO = BookAppointmentDTO::fromRequest($request);
            $therapist = $this->therapistService->findById(id: $bookAppointmentDTO->therapist_id);
            $bookAppointmentDTO->therapy_price = $therapist->therapy_price;
            $bookAppointmentDTO->client_id = auth()->id();
            $this->bookAppointmentService->store(bookAppointmentDTO: $bookAppointmentDTO);
            return apiResponse(message: __('app.book_appointments.created_successully_will_review'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    //for therapist only
    public function changeToWaitingForPaid(BookAppointment $book_appointment)
    {
        try {
            $this->bookAppointmentService->waitingForPaid(bookAppointment: $book_appointment);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (BookAppointmentStatusException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: __('app.general.there_is_an_error'), code: 500);

        }
    }

    public function changeToCompleted(BookAppointment $book_appointment)
    {
        try {
            $this->bookAppointmentService->completed(bookAppointment: $book_appointment);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (BookAppointmentStatusException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: __('app.general.there_is_an_error'), code: 500);

        }
    }

    public function changeToCanceled(BookAppointment $book_appointment)
    {
        try {
            //check who is cancel the appointment
            if (auth()->guard('api_therapist')->check()) {
                $cancel_owner = 1;
            } else {
                $cancel_owner = 2;
            }
            $this->bookAppointmentService->canceled(bookAppointment: $book_appointment,cancel_owner: $cancel_owner);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (BookAppointmentStatusException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            dd($exception);
            return apiResponse(message: __('app.general.there_is_an_error'), code: 500);

        }
    }


    public function confirmBookAppointmentPayment(ConfirmPaymentRequest $request)
    {
        try {
            $confirmPaymentData = $request->validated();
            $this->bookAppointmentService->confirmPaymentStatus($confirmPaymentData);
            return apiResponse(message: __('app.general.success_operation'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

}
