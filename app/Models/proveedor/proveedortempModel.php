<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedortempModel extends Model
{
    use HasFactory;
    protected $table = 'formulario_proveedortemp';
    protected $primaryKey = 'ID_FORMULARIO_PROVEEDORTEMP';
    protected $fillable = [
        'RFC_PROVEEDORTEMP',
        'NOMBRE_PROVEEDORTEMP',
        'RAZON_PROVEEDORTEMP',
        'GIRO_PROVEEDORTEMP',
        'ACTIVO',
        'DIRECCIONES_JSON',
        'REQUIERE_CONTRATO',
        'DOCUMENTO_SOPORTE',
        'FECHAI_CONTRATO',
        'INDETERMINADO_CONTRATO',
        'FECHAF_CONTRATO'
    ];
}
