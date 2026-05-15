<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lineanegocioModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_LINEA_NEGOCIO';
    protected $table = 'capacitacion_lineanegocios';
    protected $fillable = [
        'NOMBRE_LINEA',
        'ABREVIATURA_NEGOCIO',
        'ACTIVO'
    ];
}
