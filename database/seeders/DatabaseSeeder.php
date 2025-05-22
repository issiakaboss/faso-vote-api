<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\User;
use App\Models\Votant;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();
        Vote::factory(10)->create();
        Votant::factory(100)->create();
        Candidate::factory(10)->create();
    }
}
