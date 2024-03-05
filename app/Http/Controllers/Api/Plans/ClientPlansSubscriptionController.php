<?php

namespace App\Http\Controllers\Api\Plans;

use App\DataTransferObjects\TherapistPlans\TherapistPlansDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\TherapistPlan\TherapistPlanRequest;
use App\Http\Resources\TherapistPlans\TherapistPlansResource;
use App\Services\Plans\TherapistPlansService;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientPlansSubscriptionController extends Controller
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

}
