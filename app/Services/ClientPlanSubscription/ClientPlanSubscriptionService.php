<?php

namespace App\Services\ClientPlanSubscription;

use App\DataTransferObjects\ClientPlanSubscription\ClientPlanSubscriptionDTO;
use App\Enums\ClientPlanStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\ClientPlanSubscription;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ClientPlanSubscriptionService extends BaseService
{

    public function __construct(protected ClientPlanSubscription $model)
    {

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function destroy($client_plan_subscription_id): ?bool
    {
        return $this->getQuery()->where('id', $client_plan_subscription_id)->delete();
    }

    /**
     * @throws NotFoundException
     */
    public function confirmPaymentStatus(array $clientPlanSubscriptionData = []): Model|\Illuminate\Database\Eloquent\Collection|null
    {
        $clientPlanSubscription = $this->findById(Arr::get($clientPlanSubscriptionData, 'merchant_id'));
        $clientPlanSubscriptionData = ['transaction_id' => Arr::get($clientPlanSubscriptionData, 'transaction_id'), 'payment_status' => PaymentStatusEnum::PAID->value,'status'=>ClientPlanStatusEnum::RUNNING->value];
        $clientPlanSubscription->update($clientPlanSubscriptionData);
        $clientPlanSubscription->refresh();
        return $clientPlanSubscription;

    }

    public function subscribeToPlan(ClientPlanSubscriptionDTO $clientPlanSubscriptionDTO)
    {
        $clientPlanSubscriptionDTO->validate();
        $clientPlanSubscriptionData = $clientPlanSubscriptionDTO->toArray();
        return $this->getQuery()->create($clientPlanSubscriptionData);
    }

    public function getPlansForUser(User|int $user)
    {
        if (is_int($user)) {
            $user = parent::findById($user);
        }
        return $user->plans()->with('therapistPlan')->withCount('clientPlanNotification')->where('status',ClientPlanStatusEnum::RUNNING->value)->get();

    }
}
