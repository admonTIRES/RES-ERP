<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogojerarquiaModel extends Model
{

    protected $primaryKey = 'ID_CATALOGO_JERARQUIA';
    protected $table = 'catalogo_jerarquias';
    protected $fillable = [
        'NOMBRE_JERARQUIA',
        'DESCRIPCION_JERARQUIA',
         'ACTIVO'
    ];
}
