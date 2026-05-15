<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evidenciageneradaModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_EVIDENCIA_GENERADAS';
    protected $table = 'capacitacion_evidenciageneradas';
    protected $fillable = [
        'NOMBRE_EVIDENCIA',
        'ACTIVO'
    ];
}