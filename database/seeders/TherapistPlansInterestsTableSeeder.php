<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\TherapistPlan;
use Illuminate\Database\Seeder;

class TherapistPlansInterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $therapistPlans = TherapistPlan::query()->get();
        foreach ($therapistPlans as $therapistPlan) {
            $therapistPlan->interests()->sync([Interest::query()->inRandomOrder()->first('id')?->id]);
        }
    }
}
