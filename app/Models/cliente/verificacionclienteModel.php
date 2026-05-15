<?php

namespace App\Models\cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verificacionclienteModel extends Model
{
    protected $primaryKey = 'ID_VERIFICACION_CLIENTE';
    protected $table = 'verificacion_cliente';
    protected $fillable = [
        'CLIENTE_ID',
        'VERIFICADO_EN',
        'EVIDENCIA_VERIFICACION',
    
        ];
}
