<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incidenciasModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_INCIDENCIAS';
    protected $table = 'incidencias_contrato';
    protected $fillable = [
        'CONTRATO_ID',
        'CURP',
        'NOMBRE_DOCUMENTO_INCIDENCIAS',
        'DOCUMENTO_INCIDENCIAS',
        'FECHAI_INCIDENCIA',
        'FECHAF_INCIDENCIA',
        'NUMERO_HORAS_INCIDENCIA',
        'APLICA_AUSENTISMO',
        'ACTIVO'
    ];

}
