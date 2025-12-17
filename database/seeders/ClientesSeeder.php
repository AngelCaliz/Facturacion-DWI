<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            [
                'Documento' => '12345678',
                'cod_tipo_documento' => 1, // DNI
                'Nombres' => 'Juan',
                'Apellidos' => 'Pérez',
                'Direccion' => 'Av. Lima 101',
                'cod_ciudad' => 1, // Lima
                'Telefono' => '987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Documento' => '87654321',
                'cod_tipo_documento' => 1, // DNI
                'Nombres' => 'María',
                'Apellidos' => 'Gómez',
                'Direccion' => 'Jr. Arequipa 202',
                'cod_ciudad' => 2, // Arequipa
                'Telefono' => '999888777',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Documento' => '44556677',
                'cod_tipo_documento' => 2, // CE
                'Nombres' => 'Luis',
                'Apellidos' => 'Ramírez',
                'Direccion' => 'Calle Central 303',
                'cod_ciudad' => 3, // Trujillo
                'Telefono' => '912345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
