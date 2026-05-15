<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monedaModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_MONEDA';
    protected $table = 'capacitacion_moneda';
    protected $fillable = [
        'TIPO_MONEDA',
        'ACTIVO'
    ];
}
