<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class normatividadModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_NORMATIVIDAD_MARCO';
    protected $table = 'capacitacion_normatividad';
    protected $fillable = [
        'NOMBRE_NORMATIVIDAD',
        'ACTIVO'
    ];
}
