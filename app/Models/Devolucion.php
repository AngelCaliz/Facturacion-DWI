<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devolucion extends Model
{
    use HasFactory;
    
    // Nombre de la tabla en la base de datos
    protected $table = 'devoluciones';
    
    // Clave primaria, asumimos que es auto-incrementable
    protected $primaryKey = 'id_devolucion'; 
    public $incrementing = true;
    
    // No usamos los campos 'created_at' y 'updated_at'
    public $timestamps = false;
    
    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'cod_detallefactura',       // FK a Factura (Num_factura)
        'cod_detallearticulo',      // FK a Articulo (id_articulo)
        'Motivo', 
        'cantidad', 
        'Fecha_devolucion'          // ¡Importante!
    ];

    // Relación para saber de qué factura vino
    public function facturaOriginal() {
        return $this->belongsTo(Factura::class, 'cod_detallefactura', 'Num_factura');
    }

    // Relación para saber qué artículo se devolvió
    public function articuloDevuelto() {
        return $this->belongsTo(Articulo::class, 'cod_detallearticulo', 'id_articulo');
    }
}