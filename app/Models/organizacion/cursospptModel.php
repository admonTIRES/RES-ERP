<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cursospptModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CURSOS_PPT';
    protected $table = 'cursos_ppt';
    protected $fillable = [
        'FORMULARIO_PPT_ID',
        'CURSO_PPT',
        'CURSO_REQUERIDO',
        'CURSO_DESEABLE',
        'CURSO_CUMPLE_PPT',
        'PORCENTAJE_CURSO'

    ];
}
