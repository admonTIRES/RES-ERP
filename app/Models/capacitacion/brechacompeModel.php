<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class brechacompeModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_BRECHA_COMPETENCIAS';
    protected $table = 'brecha_competencias';
    protected $fillable = [
        'CURP',
        'NOMBRE_BRECHA',
        'PORCENTAJE_FALTANTE',
        'BRECHA_JSON',
        'ACTIVO'
    ];
}
