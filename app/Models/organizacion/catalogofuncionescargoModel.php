<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class catalogofuncionescargoModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_FUNCIONESCARGO';
    protected $table ='catalogo_funcionescargos';
    protected $fillable = [
        'TIPO_FUNCION_CARGO',
        'CATEGORIAS_CARGO',
        'DESCRIPCION_FUNCION_CARGO',
         'ACTIVO'
    ];
}
