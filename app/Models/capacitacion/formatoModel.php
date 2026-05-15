<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formatoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMATO';
    protected $table = 'capacitacion_formato';
    protected $fillable = [
        'NOMBRE_FORMATO',
        'ACTIVO'
    ];
}
