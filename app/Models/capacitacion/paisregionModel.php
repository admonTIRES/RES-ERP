<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paisregionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_PAIS_REGION';
    protected $table = 'capacitacion_paisregion';
    protected $fillable = [
        'NOMBRE_PAIS_REGION',
        'ACTIVO'
    ];
}
