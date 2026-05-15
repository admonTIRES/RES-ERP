<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogoCompotenciasGerencialesModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_CATALOGO_COMPETENCIA_GERENCIAL';
    protected $table = 'catalogo_competencias_gerenciales';
    protected $fillable = [
        'NOMBRE_COMPETENCIA_GERENCIAL',
        'DESCRIPCION_COMPETENCIA_GERENCIAL',
        'ACTIVO',
    ];

}
