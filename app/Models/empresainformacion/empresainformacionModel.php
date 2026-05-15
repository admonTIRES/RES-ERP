<?php

namespace App\Models\empresainformacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresainformacionModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_FORMULARIO_EMPRESA';
    protected $table = 'formularioempresa';
    protected $fillable = [
        'RFC_EMPRESA',
        'RAZON_SOCIAL',
        'NOMBRE_COMERCIAL',
        'REGIMEN_CAPITAL',
        'CONTACTOS_JSON',
        'DIRECCIONES_JSON',
        'SUCURSALES_JSON',
        'CUENTA_SUCURSALES',
        'ACTIVO'
    ];



}
