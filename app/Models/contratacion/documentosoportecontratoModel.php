<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosoportecontratoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_SOPORTE_CONTRATO';
    protected $table = 'documentos_soporte_contrato';
    protected $fillable = [
        'CONTRATO_ID',
        'CURP',
        'TIPO_DOCUMENTOSOPORTECONTRATO',
        'NOMBRE_DOCUMENTOSOPORTECONTRATO',
        'DOCUMENTOS_SOPORTECONTRATOS',
        'FECHAI_DOCUMENTOSOPORTECONTRATO',
        'FECHAF_DOCUMENTOSOPORTECONTRATO',
        'ACTIVO'
    ];


}
