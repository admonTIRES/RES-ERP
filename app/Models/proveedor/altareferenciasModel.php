<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altareferenciasModel extends Model
{
    use HasFactory;

    protected $table = 'formulario_altareferenciasproveedor';
    protected $primaryKey = 'ID_FORMULARIO_REFERENCIASPROVEEDOR';
    protected $fillable = [
        'RFC_PROVEEDOR',
        'NOMBRE_EMPRESA',
        'NOMBRE_CONTACTO',
        'CARGO_REFERENCIA',
        'TELEFONO_REFERENCIA',
        'CORREO_REFERENCIA',
        'PRODUCTO_SERVICIO',
        'DESDE_REFERENCIA',
        'HASTA_REFERENCIA',
        'REFERENCIA_VIGENTE',
        'ACTIVO'
    ];


}
