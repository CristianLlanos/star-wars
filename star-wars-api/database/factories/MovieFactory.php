<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Movies\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created' => now()->toIso8601String(),
            'edited' => now()->toIso8601String(),
            'producer' => $this->faker->name(),
            'title' => $this->faker->sentence(3),
            'episode_id' => $this->faker->numberBetween(1, 9),
            'director' => $this->faker->name(),
            'release_date' => $this->faker->date('Y-m-d'),
            'opening_crawl' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
            'uid' => (string) $this->faker->unique()->randomNumber(5),
        ];
    }
}
