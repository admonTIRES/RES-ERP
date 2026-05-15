<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogiroempresaModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_GIRO_EMPRESA';
    protected $table ='catalogo_giroempresa';
    protected $fillable = [
        'NOMBRE_GIRO',
        'ACTIVO'
    ];
}
