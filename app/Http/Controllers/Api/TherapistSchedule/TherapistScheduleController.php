<?php

namespace App\Http\Controllers\Api\TherapistSchedule;

use App\DataTransferObjects\TherapistSchedule\TherapistScheduleDTO;
use App\Enums\WeekDaysEnum;
use App\Exceptions\GeneralException;
use App\Exceptions\TherapistScheduleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TherapistSchedule\TherapistSceduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\Therapist\TherapistScheduleResource;
use App\Http\Resources\WeekDays\WeekDaysResource;
use App\Models\Therapist;
use App\Models\TherapistSchedule;
use App\Services\Therapist\TherapistScheduleService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TherapistScheduleController extends Controller
{
    public function __construct(protected TherapistScheduleService $therapistScheduleService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $filters['therapist_id'] = auth()->guard('api_therapist')->id();
        $schedule = $this->therapistScheduleService->getQuery($filters)->get();
        return TherapistScheduleResource::collection($schedule);

    }

    public function getDays()
    {
        $days = collect(WeekDaysEnum::values());
        return WeekDaysResource::collection($days);
    }

    public function store(TherapistSceduleRequest $request)
    {
        try {
            $therapistSceduleDTO = TherapistScheduleDTO::fromRequest($request);
            $therapistSceduleDTO->therapist_id = auth()->guard('api_therapist')->id();
            $this->therapistScheduleService->store(therapistScheduleDTO: $therapistSceduleDTO);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return apiResponse(data: ['message' => __('app.general.invaild_inputs'), 'errors' => $mappedErrors], code: 422);
        } catch (TherapistScheduleException $exception) {
            return apiResponse(message: $exception->getMessage(), code: $exception->getCode());

        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function destroy(TherapistSchedule $therapist_schedule)
    {
        try {
            $this->therapistScheduleService->destroy($therapist_schedule);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (GeneralException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function getScheduleForTherapist(Therapist $therapist)
    {
        $schedules = $this->therapistScheduleService->getSchedulesByTherapist(therapist_id: $therapist->id);
        return ScheduleResource::collection($schedules);
    }

}
