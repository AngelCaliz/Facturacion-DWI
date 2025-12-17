<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $table = 'clientes';
    protected $primaryKey = 'Documento'; 
    public $incrementing = false;
    protected $keyType = 'string'; 

    protected $fillable = [
        'Documento', 
        'cod_tipo_documento', 
        'Nombres', 
        'Apellidos', 
        'Direccion', 
        'cod_ciudad', 
        'Telefono',
    ];

    public $timestamps = false;

    // 🔥 ESTA ES LA LÍNEA QUE FALTABA, SIN ESTO NADA FUNCIONA
    public function getRouteKeyName()
    {
        return 'Documento';
    }

    public function ciudad() {
        return $this->belongsTo(Ciudad::class, 'cod_ciudad', 'Codigo_ciudad');
    }

    public function tipoDocumento() {
        return $this->belongsTo(TipoDocumento::class, 'cod_tipo_documento', 'id_tipo_documento');
    }
}