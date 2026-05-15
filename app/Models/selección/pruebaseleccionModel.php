<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pruebaseleccionModel extends Model
{
    protected $primaryKey = 'ID_PRUEBAS_SELECCION';
    protected $table = 'seleccion_prueba_conocimiento';
    protected $fillable = [
        'CURP',
        'REQUIERE_PRUEBAS',
        'PORCENTAJE_TOTAL_PRUEBA',
        'ACTIVO'
    ];
}
