<?php

namespace App\Models\ordentrabajo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_ORDEN';
    protected $table = 'formulario_ordentrabajo';
    protected $fillable = [
        'OFERTA_ID',
        'NO_ORDEN_CONFIRMACION',
        'FECHA_EMISION',
        'VERIFICADO_POR',
        'FECHA_VERIFICACION',
        'PRIORIDAD_SERVICIO',
        'FECHA_INICIO_SERVICIO',
        'UTILIZAR_COTIZACION',
        'NECESIDAD_SERVICIO_CONFIRMACION',
        'ACTIVO',
        'RAZON_CONFIRMACION',
        'COMERCIAL_CONFIRMACION',
        'RFC_CONFIRMACION',
        'GIRO_CONFIRMACION',
        'DIRECCION_CONFIRMACION',
        'PERSONA_SOLICITA_CONFIRMACION',
        'CONTACTO_CONFIRMACION',
        'CONTACTO_TELEFONO_CONFIRMACION',
        'CONTACTO_CELULAR_CONFIRMACION',
        'CONTACTO_EMAIL_CONFIRMACION',
        'SERVICIOS_JSON',
        'TITULO_CONFIRMACION',
        'OBSERVACIONES_CONFIRMACION',
        'REVISION_ORDENCOMPRA',
        'MOTIVO_REVISION_ORDENCOMPRA',

        'SELECTOR_DIRECCION',
        'SELECTOR_SOLICITA',
        'SELECTOR_CONTACTO'

    ];
}
