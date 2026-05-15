<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metodoevaluacionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_METODO_EVALUACION';
    protected $table = 'capacitacion_metodoevaluacion';
    protected $fillable = [
        'METODO_EVALUACION',
        'ACTIVO'
    ];
}
