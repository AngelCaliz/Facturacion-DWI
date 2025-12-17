<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaPagosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('forma_pagos')->insert([
            ['id_formapago' => 1, 'Descripcion_formapago' => 'Contado'],
            ['id_formapago' => 2, 'Descripcion_formapago' => 'Crédito'],
            ['id_formapago' => 3, 'Descripcion_formapago' => 'Tarjeta'],
            ['id_formapago' => 4, 'Descripcion_formapago' => 'Transferencia'],
            ['id_formapago' => 5, 'Descripcion_formapago' => 'Cheque'],
        ]);
    }
}
    