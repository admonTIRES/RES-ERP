<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class encargadosAreasModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ENCARGADO_AREA';
    protected $table = 'encargados_areas';
    protected $fillable = [
        'AREA_ID',
        'TIPO_AREA_ID',
        'NOMBRE_CARGO',
        'PROPOSITO_FINALIDAD_LIDER',
        'LUGAR_TRABAJO_LIDER'
    ];
}
