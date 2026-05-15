<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idiomaModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_IDIOMAS';
    protected $table = 'capacitacion_idiomas';
    protected $fillable = [
        'NOMBRE_IDIOMA',
        'ACTIVO'
    ];
}
