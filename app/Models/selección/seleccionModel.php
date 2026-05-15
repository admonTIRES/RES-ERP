<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seleccionModel extends Model
{
    
    protected $primaryKey = 'ID_FORMULARIO_SELECCION';
    protected $table = 'formulario_seleccion';
    protected $fillable = [
        'VACANTES_ID',
        'CATEGORIA_VACANTE',
        'CURP',
        'NOMBRE_SELC',
        'PRIMER_APELLIDO_SELEC',
        'SEGUNDO_APELLIDO_SELEC',
        'CORREO_SELEC',
        'TELEFONO1_SELECT',
        'TELEFONO2_SELECT',
        'PORCENTAJE',
        'DIA_FECHA_SELECT',
        'MES_FECHA_SELECT',
        'ANIO_FECHA_SELECT',
        'NO_CONTRATAR',
        'JUSTIFICACION',
        'ACTIVO'
    ];
}
