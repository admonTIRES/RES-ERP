<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competenciaModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_COMPETENCIA_DESARROLLA';
    protected $table = 'capacitacion_competencia';
    protected $fillable = [
        'NOMBRE_COMPETENCIAS',
        'ACTIVO'
    ];
}
