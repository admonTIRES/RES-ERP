<?php

namespace App\Models\inventariomantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entradasinventariotallerModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ENTRADA_FORMULARIO_MANTENIMIENTO';
    protected $table = 'entradas_inventario_mantenimiento';
    protected $fillable = [

        'INVENTARIO_ID',
        'FECHA_INGRESO',
        'DETALLE_OPERACION',
        'CANTIDAD_PRODUCTO',
        'VALOR_UNITARIO',
        'COSTO_TOTAL',
        'SALIDA_ID'

    ];
}
