<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inteligenciaseleccionModel extends Model
{
    protected $primaryKey = 'ID_INTELIGENCIA_SELECCION';
    protected $table = 'seleccion_inteligencia';
    protected $fillable = [
        'CURP',
        'ARCHIVO_COMPLETO',
        'ARCHIVO_COMPETENCIAS',
        'RIESGO_PORCENTAJE',
        'ACTIVO'
    ];
}
