<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosarticulosModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_DOCUMENTO_ARTICULO';
    protected $table = 'documentos_articulosalmacen';
    protected $fillable = [
        'INVENTARIO_ID',
        'NOMBRE_DOCUMENTO',
        'REQUIERE_FECHA',
        'INDETERMINADO_DOCUMENTO',
        'FECHAI_DOCUMENTO',
        'FECHAF_DOCUMENTO',
        'DOCUMENTO_ARTICULO',
        'ACTIVO',
        'TIPO_DOCUMENTO',
        'FOTO_DOCUMENTO'

    ];

    
}
