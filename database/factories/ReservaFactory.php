<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\User;
//use App\Models\Recinto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // crea un user si no existe
            //'recinto_id' => Recinto::factory(), // crea un recinto si no existe
            'price' => $this->faker->randomFloat(2, 10, 100),
            'begining_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'state' => $this->faker->boolean(),
            'observations' => $this->faker->sentence()
        ];
    }
}




