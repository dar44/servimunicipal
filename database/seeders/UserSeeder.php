<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario admin de prueba
        User::create([
            'name' => 'Admin',
            'surname' => 'Adminson',
            'dni' => '12345678A',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Contraseña segura
            'phone' => '623456789',
            'role' => 'admin',
            'image' => 'profile-images/image.png',
        ]);

        User::create([
            'name' => 'Worker',
            'surname' => 'Worker',
            'dni' => '8765431A',
            'email' => 'worker@example.com',
            'password' => Hash::make('password'), // Contraseña segura
            'phone' => '623456789',
            'role' => 'worker',
            'image' => 'profile-images/image.png',
        ]);

        // Crear 10 usuarios aleatorios
        User::factory(10)->create();
    }
}
