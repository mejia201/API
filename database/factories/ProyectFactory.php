<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyect>
 */
class ProyectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //

            'name' => $this->faker->sentence,
            'duration' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['En progreso', 'Completado', 'Pendiente']),
            'employee_id' => $this->faker->numberBetween(1,6)
        ];
    }
}
