<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacionesexternasModel extends Model
{
   
    protected $primaryKey = 'ID_RELACIONES_EXTERNAS_DPT';
    protected $table = 'relaciones_externas_dpt';
    protected $fillable = [
        'FORMULARIO_DPT_ID',
        'EXTERNAS_CONQUIEN_DPT',
        'EXTERNAS_PARAQUE_DPT',
        'EXTERNAS_FRECUENCIA_DPT',
        
    ];

}
