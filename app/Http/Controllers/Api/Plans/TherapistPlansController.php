<?php

namespace App\Http\Controllers\Api\Plans;

use App\DataTransferObjects\TherapistPlans\TherapistPlansDTO;
use App\Enums\ActivationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TherapistPlan\TherapistPlanRequest;
use App\Http\Resources\TherapistPlans\TherapistPlansResource;
use App\Models\TherapistPlan;
use App\Services\Plans\TherapistPlansService;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TherapistPlansController extends Controller
{
    public function __construct(protected TherapistPlansService $therapistPlansService)
    {
    }

    public function index()
    {
        $therapist_id = auth()->guard('api_therapist')->id();
        $therapistPlans = $this->therapistPlansService->getAll(['therapist_id' => $therapist_id]);
        return TherapistPlansResource::collection($therapistPlans);
    }

    public function store(TherapistPlanRequest $request)
    {
        try {
            $therapistPlandDTO = TherapistPlansDTO::fromRequest($request);
            $therapistPlandDTO->therapist_id = auth()->guard('api_therapist')->id();
            $this->therapistPlansService->store(therapistPlansDTO: $therapistPlandDTO);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }

    }

    public function update(TherapistPlanRequest $request, TherapistPlan $plan)
    {
        try {
            $therapistPlandDTO = TherapistPlansDTO::fromRequest($request);
            $therapistPlandDTO->therapist_id = auth()->guard('api_therapist')->id();
            $this->therapistPlansService->update(therapistPlansDTO: $therapistPlandDTO, therapistPlan: $plan);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function destroy(TherapistPlan $plan)
    {
        try {
            $this->therapistPlansService->destroy(therapistPlan: $plan);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function changeStatus($id)
    {
        try {
            $this->therapistPlansService->changeStatus(therapistPlan: $id);
            return apiResponse(message: __('app.general.success_operation'));
        } catch (NotFoundHttpException $exception) {
            return apiResponse(message: __('app.plans.plan_not_found'), code: 404);
        } catch (Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

    public function getPlansForClients()
    {
        $filters = [
          'status'=>ActivationStatus::ACTIVE->value
        ];
        $therapistPlans = $this->therapistPlansService->getAll($filters);
        return TherapistPlansResource::collection($therapistPlans);
    }


}
