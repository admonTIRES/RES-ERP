<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verificacionsolicitudModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_VERIFICACION_SOLICITUD';
    protected $table = 'verificacion_solicitud';
    protected $fillable = [
        'SOLICITUD_ID',
        'VERIFICADO_EN',
        'EVIDENCIA_VERIFICACION'
        ];
}
