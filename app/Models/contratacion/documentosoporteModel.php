<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosoporteModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_DOCUMENTO_SOPORTE';
    protected $table = 'documentos_soporte_contratacion';
    protected $fillable = [
        'CURP',
        'RENOVACION_DOCUMENTO',
        'TIPO_DOCUMENTO',
        'NOMBRE_DOCUMENTO',
        'PROCEDE_FECHA_DOC',
        'FECHAI_DOCUMENTOSOPORTE',
        'FECHAF_DOCUMENTOSOPORTE',
        'DOCUMENTO_SOPORTE',
        'ACTIVO'
    ];
}
