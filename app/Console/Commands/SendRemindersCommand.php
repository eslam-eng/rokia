<?php

namespace App\Console\Commands;

use App\Enums\ActivationStatus;
use App\Jobs\SendRemindersFcm;
use App\Models\ClientNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for send reminders of rozmanas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now(); // Get current date
        ClientNotification::query()
            ->with(['client:id,name,device_token,phone','clientPlan'])
            ->where('status', ActivationStatus::PENDING->value)
            ->where('date', $now->format('m-d'))
            ->orderBy('id')
            ->chunkById(100, function ($clientNotifications) {
                foreach ($clientNotifications as $clientNotification) {
                    $otherDate = Carbon::parse("$clientNotification->time")->format('H:i:s');

                    // Get the current time
                    $now = Carbon::now()->format('H:i:s');

                    // Convert both times to Carbon instances with timestamps
                    $otherTime = Carbon::createFromFormat('H:i:s', $otherDate);
                    $currentTime = Carbon::createFromFormat('H:i:s', $now);

                    // Calculate the difference in seconds
                    $diffInSecs = $currentTime->diffInSeconds($otherTime);
                    dispatch(new SendRemindersFcm(clientNotification: $clientNotification))
                        ->delay($diffInSecs + 60); //where 60 second (plus) this seconds where server take to re run command in cron job
                }
            });
    }
}
