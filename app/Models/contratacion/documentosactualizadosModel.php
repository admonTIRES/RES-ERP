<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosactualizadosModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_DOCUMENTOS_ACTUALIZADOS';
    protected $table = 'documento_actualizados';
    protected $fillable = [
        'DOCUMENTOS_ID',
        'CURP',
        'NOMBRE_DOCUMENTO',
        'PROCEDE_FECHA_DOC',
        'FECHAI_DOCUMENTOSOPORTE',
        'FECHAF_DOCUMENTOSOPORTE',
        'DOCUMENTO_SOPORTE',
        'ACTUALIZAR_DOCUMENTO',
        'ACTIVO',
        'ESTADO_DOCUMENTO',
        'MOTIVO_RECHAZADO'

    ];
}
