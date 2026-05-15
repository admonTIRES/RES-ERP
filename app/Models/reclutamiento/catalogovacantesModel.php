<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogovacantesModel extends Model
{

        protected $primaryKey = 'ID_CATALOGO_VACANTE';
        protected $table = 'catalogo_vacantes';
        protected $fillable = [
        'LA_VACANTES_ES',
        'CATEGORIA_VACANTE',
        'DESCRIPCION_VACANTE',
        'LUGAR_VACANTE',
        'NUMERO_VACANTE',
        'FECHA_EXPIRACION',
        'DESCRIPCION',
        'REQUISICION_ID',
        'ACTIVO'   
    ];

}
