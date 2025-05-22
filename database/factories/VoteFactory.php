<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::random() ?: User::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'end_date' => $this->faker->dateTimeBetween('+3 weeks', '+4 weeks'),
            'is_active' => $this->faker->boolean(),
            'uuid' => $this->faker->uuid(),
        ];
    }
}
