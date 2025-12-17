<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
$table->string('Num_factura', 20)->primary();
$table->string('cod_cliente', 15);
$table->string('Nombre_empleado', 30);
$table->string('Fecha_facturacion', 15);
$table->integer('cod_formapago');
$table->decimal('total_factura', 10, 0);
$table->decimal('IVA', 10, 0);
$table->timestamps();

$table->foreign('cod_cliente')->references('Documento')->on('clientes');
$table->foreign('cod_formapago')->references('id_formapago')->on('forma_pagos'); // Ojo: revisa si pusiste forma_pagos o forma_de_pagos en el archivo 4
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
