<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogoasesorModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_ASESOR';
    protected $table ='catalogo_asesores';
    protected $fillable = [
        'NOMBRE_ASESOR',
        'DESCRIPCION_ASESOR',
        'ASESOR_ES',
         'ACTIVO'
    ];
}
