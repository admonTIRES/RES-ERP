<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogoverificacionproveedorModel extends Model
{
    use HasFactory;
    protected $table = 'catalago_verificacionproveedor';
    protected $primaryKey = 'ID_CATALOGO_VERIFICACION_PROVEEDOR';
    protected $fillable = [
        'NOMBRE_VERIFICACION',
        'ACTIVO'
    ];
}
