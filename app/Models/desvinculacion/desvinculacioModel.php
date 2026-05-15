<?php

namespace App\Models\desvinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class desvinculacioModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_DESVINCULACION';
    protected $table = 'formulario_desvinculacion';
    protected $fillable = [
        'CURP',
        'DOCUMENTO_ADEUDO',
        'DOCUMENTO_BAJA',
        'DOCUMENTO_CONVENIO',
        'FECHA_BAJA',
        'ACTIVO'
    ];}
