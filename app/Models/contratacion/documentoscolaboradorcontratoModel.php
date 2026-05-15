<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentoscolaboradorcontratoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_DOCUMENTO_COLABORADOR_CONTRATO';
    protected $table = 'documentos_colaborador_contrato';
    protected $fillable = [
        'CURP',
        'TIPO_DOCUMENTO_SOPORTECONTRATO',
        'NOMBRE_DOCUMENTO_SOPORTECONTRATO',
        'DOCUMENTO_SOPORTECONTRATO',
        'ACTIVO',
        'FECHAI_DOCUMENTOSOPORTECONTRATO',
        'FECHAF_DOCUMENTOSOPORTECONTRATO',
        'FOTO_FIRMA',
        'FOTO_FIRMA_RH'
    ];

}
