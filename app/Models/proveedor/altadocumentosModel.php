<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altadocumentosModel extends Model
{
    use HasFactory;


    protected $table = 'formulario_altadocumentoproveedores';
    protected $primaryKey = 'ID_FORMULARIO_DOCUMENTOSPROVEEDOR';
    protected $fillable = [
        'RFC_PROVEEDOR',
        'TIPO_DOCUMENTO_PROVEEDOR',
        'NOMBRE_DOCUMENTO_PROVEEEDOR',
        'DOCUMENTO_SOPORTE',
        'ACTIVO'
    ];


}
