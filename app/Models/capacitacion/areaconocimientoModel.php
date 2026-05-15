<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class areaconocimientoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_AREA_CONOCIMIENTO';
    protected $table = 'capacitacion_areaconocimiento';
    protected $fillable = [
        'NOMBRE_AREA_CONOCIMIENTO',
        'ACTIVO'
    ];
}
