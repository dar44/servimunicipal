<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run()
    {
        // Ej: 10 cursos aleatorios
        Curso::factory(10)->create();
    }
}

