<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogocompetenciabasicaModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_COMPETENCIA_BASICA';
    protected $table ='catalogo_competencias_basicas';
    protected $fillable = [
        'NOMBRE_COMPETENCIA_BASICA',
        'DESCRIPCION_COMPETENCIA_BASICA',
        'ACTIVO',
    ];
}
