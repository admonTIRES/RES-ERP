<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vacantesactivasModel extends Model
{
    protected $primaryKey = 'ID_VACANTES_ACTIVAS';
    protected $table = 'vacantes_activas';
    protected $fillable = [
        'VACANTES_ID',
        'CATEGORIA_VACANTE',
        'CURP',
        'NOMBRE_AC',
        'PRIMER_APELLIDO_AC',
        'SEGUNDO_APELLIDO_AC',
        'CORREO_AC',
        'TELEFONO1_AC',
        'TELEFONO2_AC',
        'PORCENTAJE',
        'DISPONIBLE',
        'DIA_FECHA_AC',
        'MES_FECHA_AC',
        'ANIO_FECHA_AC',
        'ACTIVO'
    ];
}
