<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verificacionproveedor extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_VERIFICACION_PROVEEDOR';
    protected $table = 'verificacion_proveedor';
    protected $fillable = [
        'PROVEEDOR_ID',
        'VERIFICADO_EN',
        'EVIDENCIA_VERIFICACION',

    ];


}
