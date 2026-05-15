<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bancocvModel extends Model
{
    protected $primaryKey = 'ID_BANCO_CV';
    protected $table = 'formulario_bancocv';
    protected $fillable = [
        'AVISO_PRIVACIDAD',
        'VACANTES_POSTULACION',
        'NOMBRE_CV',
        'PRIMER_APELLIDO_CV',
        'SEGUNDO_APELLIDO_CV',
        'CORREO_CV',
        'NACIONALIDAD',
        'CURP_CV',
        'DIA_FECHA_CV',
        'MES_FECHA_CV',
        'ANIO_FECHA_CV',
        'ULTIMO_GRADO_CV',
        'NOMBRE_LICENCIATURA_CV',
        'TIPO_POSGRADO_CV',
        'NOMBRE_POSGRADO_CV',
        'ARCHIVO_CURP_CV',
        'ARCHIVO_CV',
        
        'CUENTA_TITULO_LICENCIATURA_CV',
        'CEDULA_TITULO_LICENCIATURA_CV',
        'CUENTA_TITULO_POSGRADO_CV',
        'CEDULA_TITULO_POSGRADO_CV',
        'ETIQUETA_TELEFONO1',
        'TELEFONO1',
        'ETIQUETA_TELEFONO2',
        'TELEFONO2',
         'ACTIVO',
         'GENERO',
         'INTERES_OPERATIVAS',
         'INTERES_ADMINISTRATIVA'

    ];


    protected $casts = [
        'INTERES_OPERATIVAS' => 'array',
        'INTERES_ADMINISTRATIVA' => 'array',
    ];

}
