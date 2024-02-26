<?php

namespace Database\Seeders;

use App\Models\Therapist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TherapistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Therapist::create([
            'name' => "therapist test",
            'email' => "therapist@example.com",
            'password' => bcrypt('Qwe@1234'),
            'phone' => '01022843293',
            'address' => Str::random(10),
            'therapist_commission' => fake()->numberBetween(1, 50),
            'status' => true,
            'avg_therapy_duration' => 15,
            'therapy_price' => 120,

        ]);
    }
}
