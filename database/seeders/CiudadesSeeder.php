<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ciudades')->insert([
            [
                'Codigo_ciudad' => 1,
                'Nombre_ciudad' => 'Lima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Codigo_ciudad' => 2,
                'Nombre_ciudad' => 'Arequipa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Codigo_ciudad' => 3,
                'Nombre_ciudad' => 'Cusco',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
