<?php

namespace App\Jobs;

use App\Models\ClientNotification;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRemindersFcm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ClientNotification $clientNotification)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationService = app(NotificationService::class);
        $downstreamResponse = $notificationService->sendToTokens(
            title: $this->clientNotification->title,
            body: $this->clientNotification->body,
            tokens: [$this->clientNotification->client->device_token]
        );
        if ($downstreamResponse->numberSuccess()) {
            $this->clientNotification->delete();
        }
    }
}
