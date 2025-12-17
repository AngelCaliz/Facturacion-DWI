<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;
    
    // USAMOS EL NOMBRE EXACTO QUE TIENES EN TU DB: forma_pagos
    protected $table = 'forma_pagos'; 
    
    // Clave primaria según el ERD es id_formapago [cite: 55]
    protected $primaryKey = 'id_formapago'; 
    public $incrementing = true;
    
    // DEBEMOS QUITAR ESTA LÍNEA si no usaremos las columnas created_at/updated_at. 
    // Las columnas están en tu DB, si no las usas, déjalo en false.
    public $timestamps = false; // Puedes dejarlo en false para simplificar
    
    protected $fillable = [
        'Descripcion_formapago' 
    ];
}