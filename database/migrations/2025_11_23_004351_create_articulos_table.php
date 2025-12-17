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
        Schema::create('articulos', function (Blueprint $table) {
$table->integer('id_articulo')->primary();
$table->string('descripcion', 30);
$table->integer('precio_venta');
$table->integer('precio_costo');
$table->integer('stock');
$table->integer('cod_tipo_articulo');
$table->string('cod_proveedor', 20);
$table->string('fecha_ingreso', 15);
$table->timestamps();

$table->foreign('cod_tipo_articulo')->references('id_tipoarticulo')->on('tipo_articulos');
$table->foreign('cod_proveedor')->references('No_documento')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
