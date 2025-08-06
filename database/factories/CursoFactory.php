<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'           => $this->faker->sentence(3),
            'description'    => $this->faker->paragraph(),
            'location'       => $this->faker->address(),
            'begining_date'  => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date'       => $this->faker->dateTimeBetween('+1 week', '+2 month'),
            'price'          => $this->faker->randomFloat(2, 0, 100),
            'state'          => $this->faker->randomElement(['Disponible','No disponible','Cancelado']),
            'capacity'       => $this->faker->numberBetween(5, 30),
            'image'          => 'images/default-curso.png',
        ];
    }
}
