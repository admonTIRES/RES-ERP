<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosemitidosModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_DOCUMENTOS_EMITIDOS';
    protected $table = 'capacitacion_documentosemitidos';
    protected $fillable = [
        'NOMBRE_DOCUMENTO',
        'ACTIVO'
    ];
}
