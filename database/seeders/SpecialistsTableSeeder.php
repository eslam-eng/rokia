<?php

namespace Database\Seeders;

use App\Enums\ActivationStatus;
use App\Models\Category;
use App\Models\Interest;
use App\Models\Specialist;
use Illuminate\Database\Seeder;

class SpecialistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialist::query()->insert([
            [
                'name' => fake()->name,
                'status' => ActivationStatus::ACTIVE->value,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => fake()->name,
                'status' => ActivationStatus::ACTIVE->value,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
