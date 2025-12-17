<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detalle_facturas';
    // Como agregamos un 'id' autoincremental en la migración, no tocamos $primaryKey

    protected $fillable = ['cod_factura', 'cod_articulo', 'cantidad', 'total'];

    public function articulo() {
        return $this->belongsTo(Articulo::class, 'cod_articulo', 'id_articulo'); // [cite: 72]
    }

    public function factura() {
        return $this->belongsTo(Factura::class, 'cod_factura', 'Num_factura'); // [cite: 71]
    }
}