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
        Schema::create('devoluciones', function (Blueprint $table) {
$table->id();
$table->string('cod_detallefactura', 20);
$table->integer('cod_detallearticulo');
$table->string('Motivo', 15);
$table->string('Fecha_devolucion', 10);
$table->integer('cantidad');
$table->timestamps();

$table->foreign('cod_detallefactura')->references('Num_factura')->on('facturas');
$table->foreign('cod_detallearticulo')->references('id_articulo')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
