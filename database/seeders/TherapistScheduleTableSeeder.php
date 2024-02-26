<?php

namespace Database\Seeders;

use App\Enums\ActivationStatus;
use App\Models\Category;
use App\Models\Specialist;
use App\Models\TherapistSchedule;
use Illuminate\Database\Seeder;

class TherapistScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TherapistSchedule::factory()->count(1)->create();
    }
}
