<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adendarenovacionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ADENDA_RENOVACION';
    protected $table = 'adenda_renovacion';
    protected $fillable = [
        'RENOVACION_ID',
        'FECHAI_ADENDA',
        'FECHAF_ADENDA',
        'COMENTARIO_ADENDA',
        'DOCUMENTO_ADENDA',
    ];
}

