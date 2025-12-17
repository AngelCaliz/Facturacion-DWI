<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Configuración de tabla y clave
    protected $table = 'proveedores'; 
    protected $primaryKey = 'No_documento'; 
    public $incrementing = false; 
    protected $keyType = 'string';

    // Propiedad $fillable para Asignación Masiva
    protected $fillable = [
        'No_documento', 
        'cod_tipo_documento', 
        'Nombre', 
        'Apellido', 
        'Nombre_comercial', 
        'direccion', 
        'cod_ciudad', 
        'Telefono',
    ];
    
    public $timestamps = false; 
// Archivo: app/Models/Proveedor.php
    // Relaciones
    public function tipoDocumento() {
        return $this->belongsTo(TipoDocumento::class, 'cod_tipo_documento', 'id_tipo_documento');
    }

    public function ciudad() {
        return $this->belongsTo(Ciudad::class, 'cod_ciudad', 'Codigo_ciudad');
    }

    public function articulos() {
        return $this->hasMany(Articulo::class, 'cod_proveedor', 'No_documento');
    }
}