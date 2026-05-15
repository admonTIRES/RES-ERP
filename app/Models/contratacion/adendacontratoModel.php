<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adendacontratoModel extends Model
{
     use HasFactory;
    protected $primaryKey = 'ID_ADENDA_CONTRATO';
    protected $table = 'adenda_contratos';
    protected $fillable = [
        'CONTRATO_ID',
        'FECHAI_ADENDA_CONTRATO',
        'FECHAF_ADENDA_CONTRATO',
        'COMENTARIO_ADENDA_CONTRATO',
        'DOCUMENTO_ADENDA_CONTRATO',
    ];
}
