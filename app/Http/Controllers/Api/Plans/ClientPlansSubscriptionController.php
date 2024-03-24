<?php

namespace App\Http\Controllers\Api\Plans;

use App\DataTransferObjects\ClientPlanSubscription\ClientPlanSubscriptionDTO;
use App\DataTransferObjects\TherapistPlans\TherapistPlansDTO;
use App\Events\ClientPlan\ClientPlanUpdated;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientPlanSubscription\ClientPlanSubscriptionRequest;
use App\Http\Requests\Payment\ConfirmPaymentRequest;
use App\Http\Requests\TherapistPlan\TherapistPlanRequest;
use App\Http\Resources\TherapistPlans\TherapistPlansResource;
use App\Services\ClientPlanSubscription\ClientPlanSubscriptionService;
use App\Services\Plans\TherapistPlansService;
use App\Services\UserService;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientPlansSubscriptionController extends Controller
{
    public function __construct(
        protected ClientPlanSubscriptionService $clientPlanSubscriptionService,
        protected TherapistPlansService $therapistPlansService,
        protected UserService $clientService
    )
    {
    }


    public function subscribe(ClientPlanSubscriptionRequest $request)
    {
        try {
            $therapistPlan = $this->therapistPlansService->findById($request->therapist_plan_id);
            $clientPlanSubscriptionDTO = ClientPlanSubscriptionDTO::fromRequest($request);
            $clientPlanSubscriptionDTO->therapist_id = $therapistPlan->therapist_id;
            $clientPlanSubscriptionDTO->rozmana_number = $therapistPlan->roznama_number;
            $clientPlanSubscriptionDTO->price = $therapistPlan->price;
            $clientPlanSubscription = $this->clientPlanSubscriptionService->subscribeToPlan(clientPlanSubscriptionDTO: $clientPlanSubscriptionDTO);
            return apiResponse(data:['merchant_id'=>$clientPlanSubscription->id],message: __('app.general.success_operation'));
        }catch (NotFoundException $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
        catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }


    public function confirmSubscribePlanPayment(ConfirmPaymentRequest $request)
    {
        try {
            $confirmPaymentPlanData = $request->validated();
            $clientPlanSubscription = $this->clientPlanSubscriptionService->confirmPaymentStatus($confirmPaymentPlanData);
            $client = $this->clientService->findById(id: $clientPlanSubscription->client_id);
            event(new ClientPlanUpdated(model: $clientPlanSubscription,client: $client));
            return apiResponse(message: __('app.general.success_operation'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }

}
