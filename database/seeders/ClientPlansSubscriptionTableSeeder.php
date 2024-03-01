<?php

namespace Database\Seeders;

use App\Enums\UsersType;
use App\Models\ClientInterest;
use App\Models\ClientPlanSubscription;
use App\Models\TherapistPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClientPlansSubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::query()->where('type', UsersType::CLIENT->value)->get();
        $therapistPlans = TherapistPlan::query()->get();
        ClientPlanSubscription::query()->insert([
            [
                'client_id' => $clients->first()->id,
                'therapist_plan_id' => $therapistPlans->first()->id,
                'therapist_id' => $therapistPlans->first()->therapist_id,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays($therapistPlans->first()->duration)->format('Y-m-d'),
                'price' => $therapistPlans->first()->price,
            ],
            [
                'client_id' => $clients->skip(1)->first()->id,
                'therapist_plan_id' => $therapistPlans->skip(1)->first()->id,
                'therapist_id' => $therapistPlans->skip(1)->first()->therapist_id,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays($therapistPlans->skip(1)->first()->duration)->format('Y-m-d'),
                'price' => $therapistPlans->skip(1)->first()->price,
            ]
        ]);
    }
}
