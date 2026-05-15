<?php

namespace App\Models\ordencompra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poModel extends Model
{

    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_PO';
    protected $table = 'formulario_ordencompra';
    protected $fillable = [
        'NO_PO',
        'NO_MR',
        'HOJA_ID', 
        'ACTIVO',
        'MATERIALES_JSON',
        'PROVEEDOR_SELECCIONADO',
        'SUBTOTAL',
        'IVA',
        'IMPORTE',
        'PORCENTAJE_IVA',
        'FECHA_EMISION',
        'FECHA_ENTREGA',
        'SOLICITAR_AUTORIZACION',
        'USUARIO_ID',
        'REQUIERE_COMENTARIO',
        'COMENTARIO_SOLICITUD',
        'ESTADO_APROBACION',
        'FECHA_APROBACION',
        'MOTIVO_RECHAZO',
        'APROBO_ID',
        'FECHA_SOLCITIUD',
        'REVISION_PO',
        'MOTIVO_REVISION_PO',
        'OBSERVACIONES_INDICACIONES',
        'CANCELACION_PO',
        'MOTIVO_CANCELACION',
        'CANCELO_ID',
        'FECHA_CANCELACION_PO'

    ];
}
