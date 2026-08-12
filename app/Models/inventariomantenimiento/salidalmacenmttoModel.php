<?php

namespace App\Models\inventariomantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salidalmacenmttoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_SALIDA_MTTO';
    protected $table = 'salida_almacen_mantenimiento';
    protected $fillable = [

        'USUARIO_ID',
        'SOLICITANTE_SALIDA',
        'FECHA_SALIDA',
        'FIRMO_USUARIO',
        'OBSERVACIONES_SALIDA',
        'FIRMADO_POR',
        'TIENE_ORDEN',
        'NO_ORDEN_SERVICIO',
        'NO_CUENTA_ORDEN',
        'MATERIALES_JSON',
        'FECHA_ESTIMADA_SALIDA',
        'FINALIZAR_SALIDA_ALMACEN',
        'ACTIVO'

    ];
}
