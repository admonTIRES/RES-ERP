<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogocategoriaModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_CATEGORIA';
    protected $table ='catalogo_categorias';
    protected $fillable = [
        'NOMBRE_CATEGORIA',
        'LUGAR_CATEGORIA',
        'PROPOSITO_CATEGORIA',
        'ES_LIDER_CATEGORIA',
         'ACTIVO'

    ];
}
