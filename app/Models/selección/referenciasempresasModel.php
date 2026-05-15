<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referenciasempresasModel extends Model
{
    protected $primaryKey = 'ID_LABORAL_SELECCION';
    protected $table = 'referencias_seleccion_laboral';
    protected $fillable = [
        'SELECCION_REFERENCIA_ID',
        'NOMBRE_EMPRESA',
        'COMENTARIO',
        'CUMPLE',
        'ARCHIVO_RESULTADO'
    ];
}
