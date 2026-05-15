<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actualizaciondocumnetosproveedor extends Model
{
    use HasFactory;
    protected $table = 'actualizacion_documentosproveedor';
    protected $primaryKey = 'ID_ACTUALIZACION_DOC';

    protected $fillable = [
        'RFC_PROVEEDOR',
        'ID_DOCUMENTO_PROVEEDOR',
        'ID_CATALOGO_DOCUMENTO',
        'DOCUMENTO_NUEVO',
        'ESTATUS',
        'FECHA_SOLICITUD',
        'VOBO_RH',
        'AUTORIZACION_FINAL',
        'USUARIO_VOBO',
        'AUTORIZA_ID',
        'FECHA_AUTORIZACION',
        'MOTIVO_RECHAZO',
        'FECHA_VOBO'
    ];
}
