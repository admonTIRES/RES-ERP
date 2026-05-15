<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalidadModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_MODALIDAD';
    protected $table = 'capacitacion_modalidad';
    protected $fillable = [
        'NOMBRE_MODALIDAD',
        'ACTIVO'
    ];
}
