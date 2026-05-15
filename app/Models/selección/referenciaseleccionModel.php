<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referenciaseleccionModel extends Model
{
    protected $primaryKey = 'ID_REFERENCIAS_SELECCION';
    protected $table = 'seleccion_referencias_laboral';
    protected $fillable = [
        'CURP',
        'EXPERIENCIA_LABORAL',
        'PORCENTAJE_TOTAL_REFERENCIAS',
        'ACTIVO'
    ];
}
