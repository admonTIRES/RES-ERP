<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ubicacionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_UBICACION';
    protected $table = 'capacitacion_ubicacion';
    protected $fillable = [
        'NOMBRE_UBICACION',
        'ACTIVO'
    ];
}