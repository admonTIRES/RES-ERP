<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accionesdisciplinariasModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ACCIONES_DISCIPLINARIAS';
    protected $table = 'acciones_disciplinarias_contrato';
    protected $fillable = [
        'CONTRATO_ID',
        'CURP',
        'NOMBRE_DOCUMENTO_ACCIONES',
        'DOCUMENTO_ACCIONES_DISCIPLINARIAS',
        'FECHAI_ACCION',
        'ACCION_DISCIPLINARIA',
        'SANCION_DISCIPLINARIA',
        'ACTIVO'
    ];
}
