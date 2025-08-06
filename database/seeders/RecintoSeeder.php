<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recinto;
class RecintoSeeder extends Seeder
{
    public function run()
    {

        Recinto::query()->delete();

        Recinto::create([
                'name' => 'Recinto A',
                'description' => 'Recinto destinado a eventos deportivos.',
                'ubication' => 'Calle Pintor Aparicio 123',
                'province' => 'Alicante',
                'postal_code' => '12345',
                'state' => 'Disponible',
                
        ]);

        Recinto::create([
                'name' => 'Recinto B',
                'description' => 'Recinto para conciertos y espectáculos.',
                'ubication' => 'Avenida de las Matanzas 456',
                'province' => 'Valencia',
                'postal_code' => '67890',
                'state' => 'Disponible',
        ]);

        Recinto::create([
           'name' => 'Recinto C',
                'description' => 'Centro de conferencias y exposiciones.',
                'ubication' => 'Calle Principal 789',
                'province' => 'Madrid',
                'postal_code' => '11223',
                'state' => 'No disponible',
                
        ]);
    }
}
