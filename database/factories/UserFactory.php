<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Usamos Faker con localización en español (España)
        $faker = \Faker\Factory::create('es_ES'); // Localización para España

        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'dni' => $faker->unique()->bothify('########?'), // Genera un DNI aleatorio
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => '6' . $faker->numberBetween(10000000, 99999999), // Genera un número como "672387654"
            'role' => fake()->randomElement(['user', 'admin', 'editor']),
            'image' => 'images/default-curso.png',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
