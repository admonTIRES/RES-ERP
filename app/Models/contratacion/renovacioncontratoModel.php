<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class renovacioncontratoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_RENOVACION_CONTATO';
    protected $table = 'renovacion_contrato';
    protected $fillable = [
        'CONTRATO_ID',
        'CURP',
        'NOMBRE_DOCUMENTO_RENOVACION',
        'FECHAI_RENOVACION',
        'FECHAF_RENOVACION',
        'SALARIO_RENOVACION',
        'DOCUMENTOS_RENOVACION',
        'ACTIVO',
        'PROCEDE_ADENDA'
    ];
}
