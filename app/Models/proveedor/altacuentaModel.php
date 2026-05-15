<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altacuentaModel extends Model
{
    use HasFactory;

    protected $table = 'formulario_altacuentaproveedor';
    protected $primaryKey = 'ID_FORMULARIO_CUENTAPROVEEDOR';
    protected $fillable = [
        'RFC_PROVEEDOR',
        'TIPO_CUENTA',
        'NOMBRE_BENEFICIARIO',
        'NUMERO_CUENTA',
        'TIPO_MONEDA',
        'CLABE_INTERBANCARIA',
        'CODIGO_SWIFT_BIC',
        'CODIGO_ABA',
        'DIRECCION_BANCO',
        'CIUDAD',
        'PAIS',
        'CARATULA_BANCARIA',
        'ACTIVO',
        'TIPO_BANCO'
    ];
}
