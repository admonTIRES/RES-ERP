<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altacertificacionModel extends Model
{
    use HasFactory;
    protected $table = 'formulario_altacertificacionproveedor';
    protected $primaryKey = 'ID_FORMULARIO_CERTIFICACIONPROVEEDOR';
    public $timestamps = true;
    protected $fillable = [
        'RFC_PROVEEDOR',
        'TIPO_DOCUMENTO',
        'NORMA_CERTIFICACION',
        'VERSION_CERTIFICACION',
        'ENTIDAD_CERTIFICADORA',
        'DESDE_CERTIFICACION',
        'HASTA_CERTIFICACION',
        'DOCUMENTO_CERTIFICACION',
        'NORMA_ACREDITACION',
        'VERSION_ACREDITACION',
        'ALCANCE_ACREDITACION',
        'ENTIDAD_ACREDITADORA',
        'DESDE_ACREDITACION',
        'DOCUMENTO_ACREDITACION',
        'REQUISITO_AUTORIZACION',
        'ENTIDAD_AUTORIZADORA',
        'DESDE_AUTORIZACION',
        'HASTA_ACREDITACION',
        'DOCUMENTO_AUTORIZACION',
        'NOMBRE_ENTIDAD_MEMBRESIA',
        'DESDE_MEMBRESIA',
        'HASTA_MEMBRESIA',
        'DOCUMENTO_MEMBRESIA',
        'ACTIVO'
    ];
}

