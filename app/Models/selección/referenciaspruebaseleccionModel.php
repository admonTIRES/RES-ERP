<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referenciaspruebaseleccionModel extends Model
{
    protected $primaryKey = 'ID_REFERENCIASPRUEBAS_SELECCION';
    protected $table = 'referencias_seleccion_pruebas';
    protected $fillable = [
        'SELECCION_PRUEBAS_ID',
        'TIPO_PRUEBA',
        'PORCENTAJE_PRUEBA',
        'TOTAL_PORCENTAJE',
        'ARCHIVO_RESULTADO'
    ];
}
