<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogodocumentoproveedorModel extends Model
{
    use HasFactory;
    protected $table = 'catalogo_documentosproveedor';
    protected $primaryKey = 'ID_CATALOGO_DOCUMENTOSPROVEEDOR';
    protected $fillable = [
        'NOMBRE_DOCUMENTO',
        'TIPO_PERSONA',
        'TIPO_PERSONA_OPCION',
        'DESCRIPCION_DOCUMENTO',
        'ACTIVO',
        'TIPO_DOCUMENTO',
        'ACTUALIZAR_DOCUMENTOS'
    ];
}
