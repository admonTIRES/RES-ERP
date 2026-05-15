<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buroseleccionModel extends Model
{
    
    protected $primaryKey = 'ID_BURO_SELECCION';
    protected $table = 'seleccion_buro_laboral';
    protected $fillable = [
        'CURP',
        'ARCHIVO_RESULTADO',
        'CEDULA_PROFESIONAL',
        'EXPERIENCIA_BURO',
        'EXPERIENCIA_CV',
        'LABORALES_DEMANDA',
        'NUMERO_LABORALES',
        'JUDICIALES_DEMANDA',
        'NUMERO_JUDICIALES',
        'OBSERVACIONES_BURO',
        'PORCENTAJE_TOTAL',
        'ACTIVO'
    ];
}
