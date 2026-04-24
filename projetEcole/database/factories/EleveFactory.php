<?php

namespace Database\Factories;

use App\Models\Eleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Eleve>
 */
class EleveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName(),
            'date_naissance' => fake()->date(),
            'email' => fake()->unique()->safeEmail(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
