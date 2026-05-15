<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogomediocontactoModel extends Model
{
    protected $primaryKey ='ID_CATALOGO_MEDIO';
    protected $table ='catalogo_mediocontacto';
    protected $fillable = [
        'NOMBRE_MEDIO',
        'ACTIVO'
    ];

}
