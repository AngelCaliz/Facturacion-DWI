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
        Schema::create('proveedores', function (Blueprint $table) {
$table->string('No_documento', 20)->primary();
$table->integer('cod_tipo_documento');
$table->string('Nombre', 20);
$table->string('Apellido', 20);
$table->string('Nombre_comercial', 20);
$table->string('direccion', 20);
$table->integer('cod_ciudad');
$table->string('Telefono', 15);
$table->timestamps();

$table->foreign('cod_ciudad')->references('Codigo_ciudad')->on('ciudades');
$table->foreign('cod_tipo_documento')->references('id_tipo_documento')->on('tipo_documentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
