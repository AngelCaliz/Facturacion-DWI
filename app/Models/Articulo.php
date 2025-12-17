<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulos';
    protected $primaryKey = 'id_articulo';
    public $incrementing = false; 
    protected $keyType = 'integer'; 

    protected $fillable = [
        'id_articulo',
        'descripcion',
        'precio_costo',
        'precio_venta',
        'stock',
        'cod_tipo_articulo',
        'cod_proveedor',
        'fecha_ingreso',
    ];
    
    // Relación CORREGIDA: Apunta a 'id_tipoarticulo' en la tabla 'tipo_articulos'
    public function tipoArticulo() {
        // FK en Articulo: 'cod_tipo_articulo', PK en TipoArticulo: 'id_tipoarticulo'
        return $this->belongsTo(TipoArticulo::class, 'cod_tipo_articulo', 'id_tipoarticulo'); 
    }

    // Otras relaciones...
    public function proveedor() {
        return $this->belongsTo(Proveedor::class, 'cod_proveedor', 'No_documento');
    }
}