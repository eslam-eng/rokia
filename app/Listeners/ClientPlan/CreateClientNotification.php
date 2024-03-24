<?php

namespace App\Listeners\ClientPlan;

use App\Enums\ActivationStatus as ClientNotificationStatus;
use App\Enums\ClientPlanStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Events\ClientPlan\ClientPlanUpdated;
use App\Models\ClientNotification;
use App\Services\Plans\ClientPlansSubscriptionService;
use App\Services\RozmanaService;

class CreateClientNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(public ClientPlansSubscriptionService $clientPlansSubscriptionService, public RozmanaService $rozmanaService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClientPlanUpdated $event): void
    {
        $model = $event->model; //ClientPlanSubscription
        if ($model->payment_status !=PaymentStatusEnum::PAID && $model->status != ClientPlanStatusEnum::RUNNING->value)
            return;

        $client = $event->client;
        $planInterests = $model->therapistPlan->interests()->pluck('interests.id')->toArray();
        $rozmanas = $this->rozmanaService
            ->getQuery(['interests' => $planInterests, 'therapist_id' => $model->therapist_id])
            ->inRandomOrder()
            ->limit($model->roznama_number)
            ->get();
        $clientNotifications = [];
        foreach ($rozmanas as $rozmana) {
            $clientNotifications[] = [
                'client_plan_subscription_id' => $model->id,
                'client_id' => $client->id,
                'title' => $rozmana->title,
                'body' => $rozmana->description,
                'date' => $rozmana->date,
                'time' => $rozmana->time,
            ];
        }
        ClientNotification::query()->insert($clientNotifications);
    }
}
