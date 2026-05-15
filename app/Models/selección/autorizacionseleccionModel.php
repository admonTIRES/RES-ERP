<?php

namespace App\Models\selección;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autorizacionseleccionModel extends Model
{
    protected $primaryKey = 'ID_AUTORIZACION_SELECCION';
    protected $table = 'seleccion_autorizacion';
    protected $fillable = [
        'CURP',
        'ARCHIVO_AUTORIZACION',
        'ACTIVO'
    ];}
