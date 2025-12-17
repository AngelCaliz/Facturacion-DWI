<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;
    
    // CORREGIDO: Usamos el nombre 'tipo_documentos' (plural y sin guion bajo)
    protected $table = 'tipo_documentos'; 
    
    protected $primaryKey = 'id_tipo_documento'; 
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [
        'Descripcion'
    ];
}