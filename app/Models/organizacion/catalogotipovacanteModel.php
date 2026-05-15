<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogotipovacanteModel extends Model
{
    protected $primaryKey = 'ID_CATALOGO_TIPOVACANTE';
    protected $table = 'catalogo_tipovacantes';
    protected $fillable = [
        'NOMBRE_TIPOVACANTE',
         'ACTIVO'
    ];
}
