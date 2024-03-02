<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Rozmana;
use App\Models\Therapist;
use App\Models\TherapistSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RozmanasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rosmanas = [];
        for ($start = 0 ; $start<10 ; $start++)
        {
            $rosmanas[] = [
                'title'=>fake()->title,
                'description'=>fake()->sentence,
                'date'=>fake()->date('m-d'),
                'time'=>fake()->time('H:i'),
                'therapist_id'=>Therapist::query()->inRandomOrder()->first('id')?->id,

            ];
        }
        Rozmana::query()->insert($rosmanas);
    }
}
