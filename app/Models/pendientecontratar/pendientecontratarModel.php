<?php

namespace App\Models\pendientecontratar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendientecontratarModel extends Model
{
    protected $primaryKey = 'ID_PENDIENTES_CONTRATAR';
    protected $table = 'pendientes_contratar';
    protected $fillable = [
        'CURP',
        'NOMBRE_PC',
        'PRIMER_APELLIDO_PC',
        'SEGUNDO_APELLIDO_PC',
        'DIA_FECHA_PC',
        'MES_FECHA_PC',
        'ANIO_FECHA_PC',
        'VACANTE_ID',
        'ACTIVO'
    ];
}
