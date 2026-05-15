<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogotiposervicioModel extends Model
{

    use HasFactory;
    protected $primaryKey = 'ID_CATALOGO_TIPO_SERVICIO';
    protected $table = 'catalogo_tiposervicio';
    protected $fillable = [
        'NOMBRE_TIPO_SERVICIO',
        'ACTIVO'
    ];


}
