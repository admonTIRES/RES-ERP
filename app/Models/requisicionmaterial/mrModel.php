<?php

namespace App\Models\requisicionmaterial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mrModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_MR';
    protected $table = 'formulario_requisiconmaterial';
    protected $fillable = [
        'USUARIO_ID',
        'SOLICITANTE_MR',
        'FECHA_SOLICITUD_MR',
        'AREA_SOLICITANTE_MR',
        'NO_MR',
        'MATERIALES_JSON',
        'JUSTIFICACION_MR',
        'PRIORIDAD_MR',
        'OBSERVACIONES_MR',
        'LINEA_NEGOCIOS_MR',
        'VISTO_BUENO',
        'FECHA_VISTO_MR',
        'DAR_BUENO',
        'ESTADO_APROBACION',
        'MOTIVO_RECHAZO',
        'QUIEN_APROBACION',
        'FECHA_APRUEBA_MR',
        'ACTIVO',
        'MOTIVO_RECHAZO_JEFE',
        'JEFEINMEDIATO_ID'

    ];



    public function hojasRelacionadas()
    {
        return $this->hasMany(HojaTrabajo::class, 'NO_MR', 'NO_MR');
    }

    
}
