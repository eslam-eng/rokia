<?php

namespace Database\Seeders;

use App\Enums\BookAppointmentStatusEnum;
use App\Enums\UsersType;
use App\Enums\WeekDaysEnum;
use App\Events\TherapistInvoice\TherapistInvoiceHandler;
use App\Models\BookAppointment;
use App\Models\Category;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookAppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookAppointment = BookAppointment::query()->create([
            'client_id' => User::query()->where('type', UsersType::CLIENT->value)->inRandomOrder()->first()->id,
            'therapist_id' => Therapist::query()->first()->id,
            'date' => fake()->date('Y-m-d'),
            'time' => '15:00',
            'day_id' => WeekDaysEnum::SUNDAY->value,
            'price' => 100,
            'status' => BookAppointmentStatusEnum::PENDING->value,
            'user_description' => fake()->sentence,
        ]);
        $bookAppointment2 = BookAppointment::query()->create([
            'client_id' => User::query()->where('type', UsersType::CLIENT->value)->inRandomOrder()->first()->id,
            'therapist_id' => Therapist::query()->first()->id,
            'date' => fake()->date('Y-m-d'),
            'time' => '15:00',
            'day_id' => WeekDaysEnum::SUNDAY->value,
            'price' => 100,
            'status' => BookAppointmentStatusEnum::PENDING->value,
            'user_description' => fake()->sentence,
        ]);

        event(new TherapistInvoiceHandler($bookAppointment));
        event(new TherapistInvoiceHandler($bookAppointment2));
    }
}
