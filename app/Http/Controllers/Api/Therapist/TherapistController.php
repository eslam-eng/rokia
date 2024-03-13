<?php

namespace App\Http\Controllers\Api\Therapist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Exceptions\NotFoundException;
use App\DataTransferObjects\Rate\RateDTO;
use App\Services\Therapist\TherapistService;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Therapist\TherapistResource;
use App\Http\Requests\Therapist\Api\ThereapistApiUpdateRequest;
use App\Http\Requests\Therapist\Api\TherapySessionUpdateRequest;
use App\DataTransferObjects\Therapist\Api\UpdateMainTherapisDatatDTO;
use App\DataTransferObjects\Therapist\Api\UpdateTherapySessionDataDTO;

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
     public function storeRateTherapist(Request $request, int  $therapistId)
    {
        try {
             $therapist = $this->therapistService->findById( $therapistId);
            
            if (! $therapist) {
                return apiResponse(message: 'Therapist not found', code: 404);
            }

            $rateDTO = RateDTO::fromRequest($request);
            $this->therapistService->storeRateForTherapist( $therapist, $rateDTO);
            
            return apiResponse(message: 'Rate stored successfully');
        } catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 404);
        } catch (ValidationException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
