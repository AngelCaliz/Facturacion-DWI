<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArticulo extends Model
{
    use HasFactory;
    
    protected $table = 'tipo_articulos'; 
    
    // ¡CORREGIDO! Usamos el nombre exacto de la columna de tu DB
    protected $primaryKey = 'id_tipoarticulo'; 
    
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [
        'descripcion_articulo'
    ];
}