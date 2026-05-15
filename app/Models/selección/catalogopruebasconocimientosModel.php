<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogopruebasconocimientosModel extends Model
{
    protected $primaryKey = 'ID_CATALOGO_PRUEBA_CONOCIMIENTO';
    protected $table = 'catalogo_pruebas_conocimientos';
    protected $fillable = [
        'NOMBRE_PRUEBA',
        'DESCRIPCION_PRUEBA',
         'ACTIVO'
    ];
}
