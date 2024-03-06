<?php

namespace Database\Seeders;

use App\Enums\ClientPlanStatusEnum;
use App\Enums\UsersType;
use App\Events\ClientPlan\ClientPlanUpdated;
use App\Models\ClientPlanSubscription;
use App\Models\TherapistPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientPlansSubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::query()->where('type', UsersType::CLIENT->value)->get();
        $therapistPlan = TherapistPlan::query()->whereHas('interests')->first();
        foreach ($clients as $client) {
            $clientPlan = ClientPlanSubscription::query()->create([
                'client_id' => $client->id,
                'therapist_id' => $therapistPlan->id,
                'therapist_plan_id' => $therapistPlan->id,
                'rozmana_number' => 10,
                'price' => 100,
                'status' => ClientPlanStatusEnum::RUNNING->value,
            ]);
            event(new ClientPlanUpdated(model: $clientPlan,client: $client));
        }

    }
}
