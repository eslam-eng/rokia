<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TherapistsTableSeeder::class);
        $this->call(InterestsTableSeeder::class);
        $this->call(SpecialistsTableSeeder::class);
        $this->call(TherapistScheduleTableSeeder::class);
        $this->call(TherapistPlansTableSeeder::class);
        $this->call(RozmanasTableSeeder::class);
        $this->call(RozmanaInterestsTableSeeder::class);
        $this->call(TherapistPlansInterestsTableSeeder::class);
        $this->call(ClientPlansSubscriptionTableSeeder::class);
        $this->call(BookAppointmentsTableSeeder::class);
    }
}
