<?php

namespace App\Listeners\ClientPlan;

use App\Enums\ActivationStatus as ClientNotificationStatus;
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
        $model = $event->model;
        $client = $event->client;
        $planIntersts = $model->interests()->pluck('interests.id')->toArray();
        $rozmanas = $this->rozmanaService
            ->getQuery(['interests' => $planIntersts, 'therapist_id' => $model->therapist_id])
            ->inRandomOrder()
            ->limit($model->roznama_number)
            ->get();
        $clientNotifications = [];
        foreach ($rozmanas as $rozmana) {
            $clientNotifications[] = [
                'client_id' => $client->id,
                'title' => $rozmana->title,
                'body' => $rozmana->description,
                'date' => $rozmana->date,
                'time' => $rozmana->time,
                'status' => ClientNotificationStatus::PENDING->value, // 0 -> not sending , 1 send done
            ];
        }
        ClientNotification::query()->insert($clientNotifications);
    }
}
