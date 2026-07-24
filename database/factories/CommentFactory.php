<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence(),
            'userId' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory()->create()->id,
            'publicationId' => \App\Models\Publication::inRandomOrder()->first()->publicationId ?? 1,
        ];
    }
}
