<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentoscalibracionModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_DOCUMENTO_CALIBRACION';
    protected $table = 'documentos_calibracion_mantenimiento';
    protected $fillable = [

        'MANTENIMIENTO_ID',
        'NOMBRE_DOCUMENTO_CALIBRACION',
        'FECHAI_DOCUMENTO_CALIBRACION',
        'FECHAF_DOCUMENTO_CALIBRACION',
        'DADO_ALTA_CALIBRACION',
        'PROVEEDOR_CALIBRACION',
        'NOMBRE_PROVEEDOR_CALIBRACION',
        'DOCUMENTO_CALIBRACION',
        'ACTIVO'

    ];
}
