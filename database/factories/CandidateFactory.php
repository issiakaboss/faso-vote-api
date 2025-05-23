<?php

namespace Database\Factories;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vote_id' => Vote::random() ?: Vote::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'profession' => $this->faker->word(),
            'votes_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
