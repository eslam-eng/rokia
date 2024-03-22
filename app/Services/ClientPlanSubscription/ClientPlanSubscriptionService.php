<?php

namespace App\Services\ClientPlanSubscription;

use App\DataTransferObjects\ClientPlanSubscription\ClientPlanSubscriptionDTO;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\NotFoundException;
use App\Filters\LecturesFilter;
use App\Models\ClientPlanSubscription;
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

    public function getQuery(?array $filters = []): ?Builder
    {
        return parent::getQuery($filters)
            ->when(!empty($filters), fn(Builder $builder) => $builder->filter(new LecturesFilter($filters)));
    }

    /**
     * @throws NotFoundException
     */
    public function confirmPaymentStatus(array $clientPlanSubscriptionData = []): bool
    {
        $clientPlanSubscription = $this->findById(Arr::get($clientPlanSubscriptionData, 'merchant_id'));
        if (!$clientPlanSubscription)
            throw new NotFoundException('user lecture not found');
        $userLectureUpdatedData = ['transaction_id' => Arr::get($clientPlanSubscription, 'transaction_id'), 'payment_status' => PaymentStatusEnum::PAID->value];
        return $clientPlanSubscription->update($userLectureUpdatedData);
    }

    public function subscribeToPlan(ClientPlanSubscriptionDTO $clientPlanSubscriptionDTO)
    {
        $clientPlanSubscriptionDTO->validate();
        $clientPlanSubscriptionData = $clientPlanSubscriptionDTO->toArray();
        return $this->getQuery()->create($clientPlanSubscriptionData);
    }
}
