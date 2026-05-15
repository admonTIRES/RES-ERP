<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogolineanegociosModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CATALOGO_LINEA_NEGOCIOS';
    protected $table = 'catalogo_lineanegocios';
    protected $fillable = [
        'NOMBRE_LINEA',
        'ACTIVO'
    ];

}
