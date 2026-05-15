<?php

namespace App\Models\confirmacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogoverificacioninformacionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CATALOGO_VERIFICACION_CLIENTE';
    protected $table = 'catalogo_verificacioncliente';
    protected $fillable = [
        'NOMBRE_VERIFICACION',
        'ACTIVO'
    ];
}
