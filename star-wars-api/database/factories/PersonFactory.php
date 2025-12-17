<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\People\Models\Person>
 */
class PersonFactory extends Factory
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
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female', 'n/a']),
            'skin_color' => $this->faker->safeColorName(),
            'hair_color' => $this->faker->safeColorName(),
            'height' => (string) $this->faker->numberBetween(100, 230),
            'eye_color' => $this->faker->safeColorName(),
            'mass' => (string) $this->faker->numberBetween(50, 150),
            'homeworld' => $this->faker->word(),
            'birth_year' => $this->faker->randomElement(['19BBY', '52BBY', 'unknown']),
            'url' => $this->faker->url(),
            'uid' => (string) $this->faker->unique()->randomNumber(5),
        ];
    }
}
