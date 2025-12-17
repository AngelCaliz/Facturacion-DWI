<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_documentos')->insert([
            [
                'id_tipo_documento' => 1,
                'Descripcion' => 'DNI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_documento' => 2,
                'Descripcion' => 'RUC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_documento' => 3,
                'Descripcion' => 'CE', // Carnet Extranjería
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
