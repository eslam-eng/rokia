<?php

namespace App\Services\Appointment;

use App\DataTransferObjects\BookAppointment\BookAppointmentDTO;
use App\DataTransferObjects\Slider\SliderDTO;
use App\DataTransferObjects\Therapist\CreateTherapistDTO;
use App\Enums\BookAppointmentStatusEnum;
use App\Events\TherapistInvoice\TherapistInvoiceHandler;
use App\Exceptions\BookAppointmentStatusException;
use App\Exceptions\GeneralException;
use App\Exceptions\NotFoundException;
use App\Filters\BookAppointmentsFilter;
use App\Models\BookAppointment;
use App\Models\Slider;
use App\Services\BaseService;
use App\Services\NotificationService;
use App\Services\Therapist\TherapistService;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookAppointmentService extends BaseService
{

    public function __construct(protected BookAppointment $model, protected readonly NotificationService $notificationService, protected UserService $userService, protected readonly TherapistService $therapistService)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new BookAppointmentsFilter($filters)));
    }


    public function datatable(array $filters = []): Builder
    {
        return $this->getQuery(filters: $filters)
            ->with(['client:id,name,phone','therapist:id,name'])
            ->orderBy('status')
            ->orderByDesc('date');
    }

    public function paginate(array $filters = []): Paginator
    {
        return $this->getQuery(filters: $filters)
            ->with(['client:id,name,phone','therapist:id,name'])
            ->orderBy('status')
            ->simplePaginate();
    }

    /**
     * @param CreateTherapistDTO $therapistDTO
     * @return Builder|Model|null
     */
    public function store(BookAppointmentDTO $bookAppointmentDTO)
    {
        $bookAppointmentDTO->validate();
        $bookAppointmentDate = $bookAppointmentDTO->toArray();
        return $this->getQuery()->create($bookAppointmentDate);
    }

    /**
     * @param SliderDTO $sliderDTO
     * @param int|Slider $slider
     * @return mixed
     * @throws NotFoundException
     */
    public function update(SliderDTO $sliderDTO, int|Slider $slider)
    {
        if (is_int($slider))
            $slider = $this->findById($slider);

        $sliderData = $sliderDTO->toFilteredArray();

        if (isset($sliderData['image'])) {
            //first remove the old
            $slider->clearMediaCollection('sliders');
            //second add new image
            $slider->addMediaFromRequest('image')->toMediaCollection('sliders');
        }
        return $slider->update($sliderData);
    }


    /**
     * @throws NotFoundException
     * @throws GeneralException
     */
    public function destroy(Slider|int $slider): ?bool
    {
        if (is_int($slider))
            $slider = $this->findById($slider);
        return $slider->delete();
    }


    /**
     * @throws BookAppointmentStatusException
     */
    public function waitingForPaid(BookAppointment $bookAppointment): void
    {
        if ($bookAppointment->status == BookAppointmentStatusEnum::WAITING_FOR_PAID->value)
            throw new BookAppointmentStatusException(status: BookAppointmentStatusEnum::from($bookAppointment->status)->getLabel());
        $bookAppointment->update(['status' => BookAppointmentStatusEnum::WAITING_FOR_PAID->value]);
        $this->sendFcm(bookAppointment: $bookAppointment);
    }

    /**
     * @throws BookAppointmentStatusException
     */
    public function paid(BookAppointment $bookAppointment): void
    {
        if ($bookAppointment->status == BookAppointmentStatusEnum::PAID->value)
            throw new BookAppointmentStatusException(status: BookAppointmentStatusEnum::from($bookAppointment->status)->getLabel());
        $bookAppointment->update(['status' => BookAppointmentStatusEnum::PAID->value]);
        $this->sendFcm(bookAppointment: $bookAppointment,send_to_client: false,send_to_therapist: true);

    }

    /**
     * @throws BookAppointmentStatusException
     */
    public function compoleted(BookAppointment $bookAppointment): void
    {
        if ($bookAppointment->status == BookAppointmentStatusEnum::COMPOLETED->value)
            throw new BookAppointmentStatusException(status: BookAppointmentStatusEnum::from($bookAppointment->status)->getLabel());
        $bookAppointment->update(['status' => BookAppointmentStatusEnum::COMPOLETED->value]);
        $this->sendFcm(bookAppointment: $bookAppointment);
    }

    /**
     * @throws BookAppointmentStatusException
     */
    public function canceled(BookAppointment $bookAppointment,$cancel_owner): void
    {
        if (!in_array($bookAppointment->status,[BookAppointmentStatusEnum::PENDING->value,BookAppointmentStatusEnum::WAITING_FOR_PAID->value]))
            throw new BookAppointmentStatusException(status: BookAppointmentStatusEnum::from($bookAppointment->status)->getLabel());
        $bookAppointment->update(['status' => BookAppointmentStatusEnum::CANCELED->value]);
        $this->sendFcm(bookAppointment: $bookAppointment,send_to_client: ($cancel_owner == 2),send_to_therapist: ($cancel_owner == 1));
    }

    private function sendFcm(BookAppointment $bookAppointment, bool $send_to_client = true, bool $send_to_therapist = false): void
    {
        [$clientToken,$therapistToken] = [];
        $title = __('app.appointments.appointment_notification_title', ['number' => $bookAppointment->id]);
        $body = __('app.appointments.appointment_notification_body', ['status' => BookAppointmentStatusEnum::from($bookAppointment->status)->getLabel()]);
        if ($send_to_client)
            $clientToken = $this->userService->getToken($bookAppointment->client_id);
        if ($send_to_therapist)
            $therapistToken = $this->therapistService->getToken($bookAppointment->therapist_id);
        $tokens = array_merge($clientToken, $therapistToken);
        $this->notificationService->sendToTokens(title: $title, body: $body, tokens: $tokens);
    }
}
