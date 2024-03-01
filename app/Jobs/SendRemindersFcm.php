<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
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
        public Collection $reminders,
        public User $client)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationService = app(NotificationService::class);
        foreach ($this->reminders as $reminder)
        {
            $notificationService->sendToTokens(title: $reminder->title,body: $reminder->description,tokens: [$this->client->device_token]);
            $this->release(900); //900 second equal to 15 minute
        }
    }

}
