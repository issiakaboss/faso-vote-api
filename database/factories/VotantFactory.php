<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Enums\VotantStatusEnum;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Votant>
 */
class VotantFactory extends Factory
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
            'candidate_id' => Candidate::random() ?: Candidate::factory(),
            'identity' => $this->faker->unique()->safeEmail(),
            'status' => VotantStatusEnum::random(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
