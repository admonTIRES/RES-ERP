<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogogeneroModel extends Model
{
    
    protected $primaryKey = 'ID_CATALOGO_GENERO';
    protected $table = 'catalogo_generos';
    protected $fillable = [
        'NOMBRE_GENERO',
        'DESCRIPCION_GENERO',
         'ACTIVO'
             
    ];

}
