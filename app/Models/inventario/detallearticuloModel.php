<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detallearticuloModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_DETALLE_ARTICULO';
    protected $table = 'detalle_articulo';
    protected $fillable = [
        'INVENTARIO_ID',
        'NOMBRE_COMPONENTE',
        'CODIGO_PARTE',
        'CANTIDAD_DETALLE',
        'FECHA_COMPRA',
        'REQUIERE_REEMPLAZO',
        'ACTIVO',
    ];
}
