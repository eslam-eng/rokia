<?php

namespace Database\Factories;

use App\Enums\WeekDaysEnum;
use App\Models\Therapist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TherapistScheduleFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_id' => WeekDaysEnum::SUNDAY->value,
            'start_time' => '13:00',
            'end_time' => '18:00',
            'therapist_id' => Therapist::first('id')->id
        ];
    }

}
