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
        $therapists = [
            [
                'name' => "therapist test",
                'email' => "therapist@example.com",
                'password' => bcrypt('Qwe@1234'),
                'phone' => '01022843293',
                'address' => Str::random(10),
                'therapist_commission' => fake()->numberBetween(1, 50),
                'status' => true,
                'avg_therapy_duration' => 15,
                'therapy_price' => 120,
                'create_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => "therapist2 test",
                'email' => "therapist2@example.com",
                'password' => bcrypt('Qwe@1234'),
                'phone' => '01022843222',
                'address' => Str::random(10),
                'therapist_commission' => fake()->numberBetween(1, 50),
                'status' => true,
                'avg_therapy_duration' => 15,
                'therapy_price' => 120,
                'create_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => "therapist3 test",
                'email' => "therapist3@example.com",
                'password' => bcrypt('Qwe@1234'),
                'phone' => '01022843211',
                'address' => Str::random(10),
                'therapist_commission' => fake()->numberBetween(1, 50),
                'status' => true,
                'avg_therapy_duration' => 15,
                'therapy_price' => 120,
                'create_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => "therapist4 test",
                'email' => "therapist4@example.com",
                'password' => bcrypt('Qwe@1234'),
                'phone' => '010228432155',
                'address' => Str::random(10),
                'therapist_commission' => fake()->numberBetween(1, 50),
                'status' => true,
                'avg_therapy_duration' => 15,
                'therapy_price' => 120,
                'create_at' => now(),
                'updated_at' => now(),

            ]
        ];
        Therapist::query()->insert($therapists);
    }
}
