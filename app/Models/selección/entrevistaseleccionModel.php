<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entrevistaseleccionModel extends Model
{
    use HasFactory;


    protected $primaryKey = 'ID_ENTREVISTA_SELECCION';
    protected $table = 'seleccion_entrevista';
    protected $fillable = [
        'CURP',
        'COMENTARIO_ENTREVISTA',
        'NOMBRE_ENTREVISTA',
        'FECHA_ENTREVISTA',
        'PORCENTAJE_ENTREVISTA',
        'ARCHIVO_ENTREVISTA',
        'ACTIVO'
    ];


}
