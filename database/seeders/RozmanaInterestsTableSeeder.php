<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Rozmana;
use App\Models\RozmanaInterest;
use Illuminate\Database\Seeder;

class RozmanaInterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rosmanaIntersts = [];
        for ($start = 0; $start < 10; $start++) {
            $rosmanaIntersts[] = [
                'interest_id' => Interest::query()->inRandomOrder()->first('id')?->id,
                'rozmana_id' => Rozmana::query()->inRandomOrder()->first('id')?->id,

            ];
        }
        RozmanaInterest::query()->insert($rosmanaIntersts);
    }
}
