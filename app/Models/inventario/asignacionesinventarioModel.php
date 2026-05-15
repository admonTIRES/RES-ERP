<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignacionesinventarioModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ASIGNACION_FORMULARIO';
    protected $table = 'asignaciones_inventario';
    protected $fillable = [
        'ASIGNADO_ID',
        'INVENTARIO_ID',
        'FECHA_ASIGNACION',
        'CANTIDAD_SALIDA'
    ];

}
