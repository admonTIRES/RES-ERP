<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoproveedorModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_TIPO_PROVEEDOR';
    protected $table = 'capacitacion_tipoproveedor';
    protected $fillable = [
        'TIPO_PROVEEDOR',
        'ACTIVO'
    ];
}
