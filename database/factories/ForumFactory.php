<?php

namespace Database\Factories;

use App\Models\Forum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Forum>
 */
class ForumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
        ];
    }
}
