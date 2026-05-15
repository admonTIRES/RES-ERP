<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requisicioncontratacion extends Model
{
    use HasFactory;


    protected $primaryKey = 'ID_CONTRATACION_REQUERIMIENTO';
    protected $table = 'contratacion_requisicion';
    protected $fillable = [
        'SELECCIONAR_CATEGORIA_RP',
        'CURP',
        'FECHA_RP',
        'PRIORIDAD_RP',
        'TIPO_VACANTE_RP',
        'MOTIVO_VACANTE_RP',
        'SUSTITUYE_RP',
        'SUSTITUYE_CATEGORIA_RP',
        'CENTRO_COSTO_RP',
        'AREA_RP',
        'NO_VACANTES_RP',
        'PUESTO_RP',
        'FECHA_INICIO_RP',
        'OBSERVACION1_RP',
        'OBSERVACION2_RP',
        'OBSERVACION3_RP',
        'OBSERVACION4_RP',
        'OBSERVACION5_RP',
        'CORREO_CORPORATIVO_RP',
        'TELEFONO_CORPORATIVO_RP',
        'SOFTWARE_RP',
        'VEHICULO_EMPRESA_RP',
        'SOLICITA_RP',
        'AUTORIZA_RP',
        'NOMBRE_SOLICITA_RP',
        'NOMBRE_AUTORIZA_RP',
        'CARGO_SOLICITA_RP',
        'CARGO_AUTORIZA_RP',
        'FECHA_CREACION',
        'DOCUMENTO_REQUISICION',
        'ANTES_DE1',
        'ACTIVO',

        'USUARIO_ID',

        'ESTADO_SOLICITUD',
        'NOMBRE_APROBO_RP',
        'FECHA_APROBO_RP',
        
        'APROBO_ID',
        'MOTIVO_RECHAZO_RP'


    ];


}
