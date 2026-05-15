<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosPPTModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_DOCUMENTO_PPT';
    protected $table = 'documentos_ppt';
    protected $fillable = [
        'USUARIO_ID',
        'DEPARTAMENTO_AREA_ID',
        'FORMULARIO_PPT_ID',
        'RUTA_PPT'
    ];
}
