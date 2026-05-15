<?php

namespace App\Models\confirmacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmacionModel extends Model
{
     use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_CONFRIMACION';
    protected $table = 'formulario_confirmacion';
    protected $fillable = [
        'OFERTA_ID',
        'ACEPTACION_CONFIRMACION',
        'FECHA_CONFIRMACION',
        'QUIEN_ACEPTA',
        'CARGO_ACEPTACION',
        'DOCUMENTO_ACEPTACION',
        'PROCEDE_ORDEN',
        'NO_CONFIRMACION',
        'FECHA_EMISION',
        'FECHA_VALIDACION',
        'ACTIVO',
        'QUIEN_VALIDA',
        'COMENTARIO_VALIDACION',
        'VERIFICACION_INFORMACION',
        'ESTADO_VERIFICACION',
        ''
    ];
}

