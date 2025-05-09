<?php

namespace App\Http\Controllers\Api\Therapist;

use App\DataTransferObjects\Therapist\Api\UpdateMainTherapisDatatDTO;
use App\DataTransferObjects\Therapist\Api\UpdateTherapySessionDataDTO;
use App\Enums\ActivationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Therapist\Api\TherapySessionUpdateRequest;
use App\Http\Requests\Therapist\Api\ThereapistApiUpdateRequest;
use App\Http\Resources\Therapist\TherapistResource;
use App\Models\Therapist;
use App\Services\Therapist\TherapistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TherapistController extends Controller
{
    public function __construct(protected TherapistService $therapistService)
    {
    }

    public function index(Request $request)
    {
        $filters = array_filter($request->all(), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $filters['status'] = ActivationStatus::ACTIVE->value;
        $therapists = $this->therapistService->paginate(filters: $filters);
        return TherapistResource::collection($therapists);
    }

    public function getProfileDetails()
    {
        try {
            $therapist = Auth::guard('api_therapist')->user();
            $therapistDetails = $this->therapistService->getTherapistDetails(therapist: $therapist);
            return apiResponse(data: TherapistResource::make($therapistDetails), message: trans('app.general.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }

    public function getTherapistDetailsForClient(Therapist $therapist)
    {
        try {
            $therapist = $this->therapistService->getTherapistDetailsForClient(therapist: $therapist);
            return apiResponse(data: TherapistResource::make($therapist), message: trans('app.general.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 500);
        }
    }

    public function updateProfileData(ThereapistApiUpdateRequest $request)
    {
        try {
            $therapistDTO = UpdateMainTherapisDatatDTO::fromRequest($request);
            $therapist = auth()->guard('api_therapist')->user();
            $this->therapistService->updateProfileData(therapistDTO: $therapistDTO, therapist: $therapist);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (ValidationException $exception) {
            $mappedErrors = transformValidationErrors($exception->errors());
            return apiResponse(data: ['message' => __('app.general.invaild_inputs'), 'errors' => $mappedErrors], code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function updateTherapyData(TherapySessionUpdateRequest $request)
    {
        try {
            $therapist = auth()->guard('api_therapist')->user();
            $therapySessionDTO = UpdateTherapySessionDataDTO::fromRequest($request);
            $therapist = $this->therapistService->updateTherapySessionData(therapySessionDataDTO: $therapySessionDTO, therapist: $therapist);
            return apiResponse(data: TherapistResource::make($therapist), message: __('app.general.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
