<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacionmedicaModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_INFORMACION_MEDICA';
    protected $table = 'informacion_medica_contrato';
    protected $fillable = [
        'CONTRATO_ID',
        'CURP',
        'NOMBRE_DOCUMENTO_INFORMACION',
        'DOCUMENTO_INFORMACION_MEDICA',
        'ACTIVO',

        'OBSERVACIONES_SOLICITUD',
        'FECHA_EXAMEN_MEDICA',
        'PROVEEDOR_INFORMACION',
        'DICTAMEN_INFORMACION'
    ];

}
