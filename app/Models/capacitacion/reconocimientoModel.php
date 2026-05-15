<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reconocimientoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_RECONOCIMIENTO';
    protected $table = 'capacitacion_reconocimiento';
    protected $fillable = [
        'NOMBRE_RECONOCIMIENTO',
        'ACTIVO'
    ];
}