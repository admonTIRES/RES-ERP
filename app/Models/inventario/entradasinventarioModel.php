<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entradasinventarioModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ENTRADA_FORMULARIO';
    protected $table = 'entradas_inventario';
    protected $fillable = [

        'INVENTARIO_ID',
        'FECHA_INGRESO',
        'DETALLE_OPERACION',
        'CANTIDAD_PRODUCTO',
        'VALOR_UNITARIO',
        'COSTO_TOTAL',

    ];
}
