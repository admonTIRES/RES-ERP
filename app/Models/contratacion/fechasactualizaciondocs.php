<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fechasactualizaciondocs extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ACTUALIZACION_DOCUMENTOS';
    protected $table = 'fechas_actualizaciondocs';
    protected $fillable = [
        'FECHA_INICIO',
        'FECHA_FIN',
        'TIPO_DOCUMENTO',
        'ACTIVO',
    ];



    }
