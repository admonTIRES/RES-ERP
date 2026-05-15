<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class areasModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_AREA';
    protected $table = 'areas';
    protected $fillable = [
        'NOMBRE',
        'DESCRIPCION',
        'TIPO_AREA_ID',
        'USUARIO_ID',
        'DOCUMENTO_ORGANIGRAMA',
        'FOTO_ORGANIGRAMA',
        'ACTIVO'
    ];

}
