<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altacontactos extends Model
{
    protected $table = 'formulario_altacontactoproveedor';
    protected $primaryKey = 'ID_FORMULARIO_CONTACTOPROVEEDOR';
    protected $fillable = [
        'RFC_PROVEEDOR',
        'FUNCIONES_CUENTA',
        'TITULO_CUENTA',
        'NOMBRE_CONTACTO_CUENTA',
        'CARGO_CONTACTO_CUENTA',
        'TELEFONO_CONTACTO_CUENTA',
        'EXTENSION_CONTACTO_CUENTA',
        'CELULAR_CONTACTO_CUENTA',
        'CORREO_CONTACTO_CUENTA',
        'ACTIVO'
    ];
}
