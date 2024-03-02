<?php

namespace App\Console\Commands;

use App\Jobs\SendRemindersFcm;
use App\Models\Rozmana;
use App\Models\User;
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
        $today = Carbon::now()->format('m-d'); // Get current date

        $clientsHasTherapistPlan = User::query()
            ->select(['id', 'name', 'device_token'])
            ->withWhereHas('plans', fn($query) => $query->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d')))
            ->with('interests')
            ->get();

        foreach ($clientsHasTherapistPlan as $client) {
            $interests = $client->interests->pluck('id')->toArray();
            foreach ($client->plans as $plan) {
                $rozmanas = Rozmana::query()
                    ->where('therapist_id', $plan->therapist_id)
                    ->where('date',$today)
                    ->whereHas('interests', fn($query) => $query->whereIn('interest_id', $interests))->get();
                if ($rozmanas->isNotEmpty())
                    dispatch(new SendRemindersFcm(reminders: $rozmanas, client: $client));
            }
        }
    }
}
