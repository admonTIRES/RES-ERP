<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacionmttoModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_INFORMACION_MTTO';
    protected $table = 'informacion_mtto';
    protected $fillable = [

        'MANTENIMIENTO_ID',
        'CRITERIO_MTTO',
        'TIPO_MTTO',
        'PROVEEDOR_INTEXT_MTTO',
        'PROVEEDOR_INTERNO_MTTO',
        'PROVEEDOR_EXTERNO_MTTO',
        'FECHA_ULTIMO_MTTO'

    ];

}
