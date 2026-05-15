<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogofuncionesproveedorModel extends Model
{
    protected $table = 'catalogo_funcionesproveedor';
    protected $primaryKey = 'ID_CATALOGO_FUNCIONESPROVEEDOR';
    protected $fillable = [
        'NOMBRE_FUNCIONES',
        'DESCRIPCION_FUNCIONES',
        'ACTIVO'
    ];
}
