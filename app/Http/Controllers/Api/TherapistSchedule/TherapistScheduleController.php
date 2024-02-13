<?php

namespace App\Http\Controllers\Api\TherapistSchedule;

use App\DataTransferObjects\TherapistSchedule\TherapistScheduleDTO;
use App\Enums\WeekDaysEnum;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TherapistSchedule\TherapistSceduleRequest;
use App\Http\Resources\Therapist\TherapistScheduleResource;
use App\Http\Resources\WeekDays\WeekDaysResource;
use App\Models\TherapistSchedule;
use App\Services\TherapistScheduleService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TherapistScheduleController extends Controller
{
    public function __construct(protected TherapistScheduleService $therapistScheduleService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
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
            $this->therapistScheduleService->store(therapistScheduleDTO: $therapistSceduleDTO);
            return apiResponse(message: 'created sucessfully');
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return apiResponse(data: ['message' => __('lang.invalid inputs'), 'errors' => $mappedErrors], code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function destroy(TherapistSchedule $therapist_schedule)
    {
        try {
            $this->therapistScheduleService->destroy($therapist_schedule);
            return apiResponse(message: 'deleted successfully');
        } catch (GeneralException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


}
