<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cataloareainteresModel extends Model
{
    
    protected $primaryKey ='ID_CATALOGO_AREAINTERES';
    protected $table ='catalogo_areainteres';
    protected $fillable = [
        'TIPO_AREA',
        'NOMBRE_AREA',
        'ACTIVO'
    ];


}
