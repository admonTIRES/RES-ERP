<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contratoproveedorModel extends Model
{
    use HasFactory;
    protected $table = 'contratos_proveedores';
    protected $primaryKey = 'ID_CONTRATO_PROVEEDORES';
    protected $fillable = [
        'NUMERO_CONTRATO_PROVEEDOR',
        'MONTO_CONTRATO_PROVEEDOR',
        'MONEDA_CONTRATO_PROVEEDOR',
        'FECHAI_CONTRATO_PROVEEDOR',
        'FECHAF_CONTRATO_PROVEEDOR',
        'DOCUMENTO_CONTRATO_PROVEEDOR',
        'RFC_PROVEEDOR',
        'PROCEDE_ADENDA_CONTRATO',
        'CONSECUTIVO_CONTRATO',
        'ACTIVO'
    ];
}
