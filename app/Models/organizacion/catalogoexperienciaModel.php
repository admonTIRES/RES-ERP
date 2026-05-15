<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogoexperienciaModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_EXPERIENCIA';
    protected $table ='catalogo_experienciapuesto';
    protected $fillable = [
        'NOMBRE_PUESTO',
        'ACTIVO',
    ];
}
