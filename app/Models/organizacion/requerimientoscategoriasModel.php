<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requerimientoscategoriasModel extends Model
{
    protected $primaryKey = 'ID_REQUERIMIENTOS_CATEGORIAS';
    protected $table = 'requerimientos_categorias';
    protected $fillable = [
        'CATALOGO_CATEGORIAS_ID',
        'TIPO_PRUEBA',
        'PORCENTAJE'
       
    ];
}
