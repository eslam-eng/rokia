<?php

namespace Database\Factories;

use App\Enums\ActivationStatus;
use App\Enums\LecturesTypeEnum;
use App\Models\Lecture;
use App\Models\Therapist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LectureFactory extends Factory
{
    protected $model = Lecture::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'therapist_id' => Therapist::query()->inRandomOrder()->first()?->id,
            'duration' => fake()->numberBetween(10, 30),
            'description' => fake()->paragraph(1),
            'price' => fake()->numberBetween(10, 30),
            'status' => ActivationStatus::ACTIVE->value,
            'is_paid' => fake()->boolean,
            'type' => LecturesTypeEnum::RECORDED->value,
        ];
    }

}
