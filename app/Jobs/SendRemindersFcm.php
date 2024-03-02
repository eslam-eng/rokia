<?php

namespace App\Jobs;

use App\Models\Rozmana;
use App\Models\User;
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
    public function __construct(
        public Rozmana $reminder,
        public User    $client)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationService = app(NotificationService::class);
        $notificationService->sendToTokens(
            title: $this->reminder->title,
            body: $this->reminder->description,
            tokens: [$this->client->device_token]
        );
    }

}
