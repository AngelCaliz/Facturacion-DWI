<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    
    // CORREGIDO: Usamos el nombre 'ciudades' (plural)
    protected $table = 'ciudades'; 
    
    protected $primaryKey = 'Codigo_ciudad';
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [
        'Nombre_ciudad'
    ];
}