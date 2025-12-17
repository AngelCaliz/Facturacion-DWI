<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'Num_factura'; // [cite: 62]
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Num_factura', 'cod_cliente', 'Nombre_empleado', 'Fecha_facturacion', 'cod_formapago', 'total_factura', 'IVA'];

    // Relación con el Cliente
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cod_cliente', 'Documento'); // [cite: 63]
    }

    // Relación con los Detalles (Una factura tiene muchos items)
    public function detalles() {
        return $this->hasMany(DetalleFactura::class, 'cod_factura', 'Num_factura'); // [cite: 71]
    }
    public function formaPago()
    {
        return $this->belongsTo(FormaPago::class, 'cod_formapago', 'id_formapago');
    }
}