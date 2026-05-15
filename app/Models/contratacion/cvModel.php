<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cvModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CV_CONTRATACION';
    protected $table = 'cv_contratacion';
    protected $fillable = [
        'CURP',
        'NOMBRE_CV',
        'CARGO_CV',
        'PROFESION_CV',
        'NACIONALIDAD_CV',
        'FOTO_CV',
        'DESCRIPCION_PERFIL_CV',
        'FORMACION_ACADEMICA_CV',
        'DOCUMENTO_ACADEMICOS_CV',
        'REQUIERE_CEDULA_CV',
        'ESTATUS_CEDULA_CV',
        'NOMBRE_CEDULA_CV',
        'NUMERO_CEDULA_CV',
        'EMISION_CEDULA_CV',
        'DOCUMENTO_CEDULA_CV',
        'DOCUMENTO_VALCEDULA_CV',
        'EXPERIENCIA_LABORAL_CV',
        'EDUCACION_CONTINUA_CV',
        'ACTIVO'

        
    ];


}
