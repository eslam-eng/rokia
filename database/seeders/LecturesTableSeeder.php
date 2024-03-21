<?php

namespace Database\Seeders;

use App\Enums\ActivationStatus;
use App\Models\Category;
use App\Models\Lecture;
use App\Models\Specialist;
use Illuminate\Database\Seeder;

class LecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecture::factory()->count(10)->create();
    }
}
