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
        Schema::create('detalle_facturas', function (Blueprint $table) {
$table->id();
$table->string('cod_factura', 20);
$table->integer('cod_articulo');
$table->integer('cantidad');
$table->decimal('total', 10, 0);
$table->timestamps();

$table->foreign('cod_factura')->references('Num_factura')->on('facturas')->onDelete('cascade');
$table->foreign('cod_articulo')->references('id_articulo')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_facturas');
    }
};
