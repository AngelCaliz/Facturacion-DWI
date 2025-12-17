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
        Schema::create('clientes', function (Blueprint $table) {
$table->string('Documento', 15)->primary();
$table->integer('cod_tipo_documento');
$table->string('Nombres', 30);
$table->string('Apellidos', 30);
$table->string('Direccion', 20);
$table->integer('cod_ciudad');
$table->string('Telefono', 20);
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
        Schema::dropIfExists('clientes');
    }
};
