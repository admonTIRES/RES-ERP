<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fechaactualizacionModel extends Model
{
    use HasFactory;
    protected $table = 'fecha_actualizaciondocsproveedor';
    protected $primaryKey = 'ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR';
    protected $fillable = [
        'FECHA_INICIO',
        'FECHA_FIN',
        'ACTIVO',
        
    ];
}
