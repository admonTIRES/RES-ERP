<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cursospptseleccionModel extends Model
{
    use HasFactory;


    use HasFactory;
    protected $primaryKey = 'ID_CURSOS_SELECCION_PPT';
    protected $table = 'cursos_seleccion_ppt';
    protected $fillable = [
        'SELECCION_PPT_ID',
        'CURSO_PPT',
        'CURSO_REQUERIDO',
        'CURSO_DESEABLE',
        'CURSO_CUMPLE_PPT',
        'PORCENTAJE_CURSO'
    ];


}
