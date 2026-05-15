<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalonecesidadModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_NECESIDAD_SERVICIO';
    protected $table ='catalogo_necesidadservicio';
    protected $fillable = [
        'DESCRIPCION_NECESIDAD',
        'ACTIVO'
    ];
}
