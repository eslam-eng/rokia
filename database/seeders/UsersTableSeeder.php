<?php

namespace Database\Seeders;

use App\Enums\UsersType;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Services\LocationsService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insert([
            [
                'name' => "admin",
                'email' => "admin@admin.com",
                'password' => bcrypt('Qwe@1234'),
                'phone' => '01113622098',
                'address' => Str::random(10),
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name' => "client",
                'email' => "client@admin.com",
                'password' => bcrypt('123456789'),
                'phone' => '01022843293',
                'address' => Str::random(10),
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);
    }
}
