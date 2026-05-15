<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignacionproveedorModel extends Model
{

    use HasFactory;
    protected $primaryKey = 'ID_ASINGACIONES_PROVEEDORES';
    protected $table = 'asignaciones_proveedores';
    protected $fillable = [

        'ASIGNACIONES_ID',
        'TIPO_ASIGNACION',
        'PERSONAL_ASIGNA',
        'FECHA_ASIGNACION',
        'ALMACENISTA_ASIGNACION',
        'ACTIVO',
        'DOCUMENTO_ASIGNACION',
        'RFC',
        'EPP_JSON'
    ];
}
