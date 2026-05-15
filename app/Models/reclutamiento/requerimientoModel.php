<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requerimientoModel extends Model
{
    protected $primaryKey = 'ID_REQUERIMIENTOS_VACANTES';
    protected $table = 'requerimientos_vacantes';
    protected $fillable = [
        'CATALOGO_VACANTES_ID',
        'NOMBRE_REQUERIMINETO',
        'PORCENTAJE'
       
    ];
}
