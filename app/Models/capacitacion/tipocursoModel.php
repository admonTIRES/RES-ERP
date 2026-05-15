<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipocursoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_TIPO_CURSO';
    protected $table = 'capacitacion_tipocurso';
    protected $fillable = [
        'TIPO_CURSO',
        'ACTIVO'
    ];
}
