<?php

namespace Database\Seeders;

use App\Enums\ActivationStatus;
use App\Models\Category;
use App\Models\Therapist;
use App\Models\TherapistPlan;
use App\Models\TherapistSchedule;
use Illuminate\Database\Seeder;

class TherapistPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TherapistPlan::query()->insert([
            [
                'therapist_id'=>Therapist::query()->inRandomOrder()->first()?->id,
                'name'=>'test paln1',
                'duration'=>15,
                'price'=>100,
                'status'=>ActivationStatus::ACTIVE->value
            ],
            [
                'therapist_id'=>Therapist::query()->inRandomOrder()->first()?->id,
                'name'=>'test paln2',
                'duration'=>30,
                'price'=>200,
                'status'=>ActivationStatus::ACTIVE->value
            ],
        ]);
    }
}
