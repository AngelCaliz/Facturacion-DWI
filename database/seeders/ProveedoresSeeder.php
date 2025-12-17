<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            [
                'No_documento' => '12345678',
                'cod_tipo_documento' => 1, // debe existir en tipo_documentos
                'Nombre' => 'Carlos',
                'Apellido' => 'Rojas',
                'Nombre_comercial' => 'ElectroPeru',
                'direccion' => 'Av. Lima 123',
                'cod_ciudad' => 1, // debe existir en ciudades
                'Telefono' => '987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'No_documento' => '87654321',
                'cod_tipo_documento' => 1,
                'Nombre' => 'María',
                'Apellido' => 'Lopez',
                'Nombre_comercial' => 'FashionStore',
                'direccion' => 'Jr. Arequipa 456',
                'cod_ciudad' => 2,
                'Telefono' => '999888777',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'No_documento' => '55554444',
                'cod_tipo_documento' => 2,
                'Nombre' => 'Luis',
                'Apellido' => 'Gomez',
                'Nombre_comercial' => 'ConstruMarket',
                'direccion' => 'Av. Central 890',
                'cod_ciudad' => 3,
                'Telefono' => '912345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
