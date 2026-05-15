<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogomotivovacanteModel extends Model
{
    protected $primaryKey = 'ID_CATALOGO_MOTIVOVACANTE';
    protected $table = 'catalogo_motivovacantes';
    protected $fillable = [
        'NOMBRE_MOTIVO_VACANTE',
         'ACTIVO'
    ];
}
