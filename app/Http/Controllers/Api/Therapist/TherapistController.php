<?php

namespace App\Http\Controllers\Api\Therapist;

use App\DataTransferObjects\Therapist\Api\UpdateTherapistDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Therapist\Api\ThereapistApiUpdateRequest;
use App\Http\Requests\Therapist\Api\ThereapistSpecialistsRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\Therapist\TherapistResource;
use App\Models\Therapist;
use App\Services\TherapistService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TherapistController extends Controller
{
    public function __construct(protected TherapistService $therapistService)
    {
    }

    public function getProfileDetails()
    {
        try {
            $therapist = Auth::guard('api_therapist')->user();
            $therpaistDetails = $this->therapistService->getTherapistDetails(therapist: $therapist);
            return apiResponse(data: TherapistResource::make($therpaistDetails), message: trans('app.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }

    public function update(ThereapistApiUpdateRequest $request)
    {
        try {
            $therapistDTO = UpdateTherapistDTO::fromRequest($request);
            $therapist = auth()->guard('api_therapist')->user();
            $this->therapistService->update(therapistDTO: $therapistDTO, therapist: $therapist);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return apiResponse(data: ['message' => __('app.general.invaild_inputs'), 'errors' => $mappedErrors], code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function updateSpecialists(ThereapistSpecialistsRequest $request)
    {
        $therapist = auth()->guard('api_therapist')->user();
        $therapist->spaecialists()->sync($request->categories);
        return apiResponse(message: __('app.general.success_operation'));
    }
}
