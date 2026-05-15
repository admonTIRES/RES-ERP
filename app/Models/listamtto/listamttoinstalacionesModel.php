<?php

namespace App\Models\listamtto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listamttoinstalacionesModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_FORMULARIO_INSTALACIONES';
    protected $table = 'formulario_mttoinstalaciones';
    protected $fillable = [

        'FOTO_INSTALACION',
        'DESCRIPCION_INSTALACION',
        'UBICACION_INSTALACION',
        'ESPECIFICACIONES_INSTALACION',
        'ANIO_CONSTRUCCION_INSTALACION',
        'PROVEEDOR_ALTA',
        'PROVEEDOR_INSTALACION',
        'NOMBRE_PROVEEDOR_INSTALACION',
        'MANTENIMIENTO_INSTALACION',
        'ACTIVO'

    ];
}
