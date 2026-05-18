<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignacioncontratacionModel extends Model
{


    use HasFactory;
    protected $primaryKey = 'ID_ASINGACIONES_CONTRATACION';
    protected $table = 'asignaciones_contratacion';
    protected $fillable = [
        'CONTRATO_ID',
        'ASIGNACIONES_ID',
        'TIPO_ASIGNACION',
        'PERSONAL_ASIGNA',
        'FECHA_ASIGNACION',
        'ALMACENISTA_ASIGNACION',
        'ACTIVO',
        'DOCUMENTO_ASIGNACION',
        'CURP',
        'EPP_JSON'
    ];


   

    }
