<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoArticulosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_articulos')->insert([
            [
                'id_tipoarticulo' => 1,
                'descripcion_articulo' => 'Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoarticulo' => 2,
                'descripcion_articulo' => 'Ropa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoarticulo' => 3,
                'descripcion_articulo' => 'Alimentos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoarticulo' => 4,
                'descripcion_articulo' => 'Herramientas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoarticulo' => 5,
                'descripcion_articulo' => 'Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
