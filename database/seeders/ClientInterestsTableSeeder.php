<?php

namespace Database\Seeders;

use App\Enums\UsersType;
use App\Models\ClientInterest;
use App\Models\Interest;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientInterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::query()->where('type', UsersType::CLIENT->value)->get();
        foreach ($clients as $client) {
            ClientInterest::query()->create([
                'client_id' => $client->id,
                'interest_id' => Interest::query()->inRandomOrder()->first()->id,
            ]);
        }
    }
}
