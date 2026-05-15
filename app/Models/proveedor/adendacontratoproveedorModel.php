<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adendacontratoproveedorModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ADENDA_CONTRATO_PROVEEDOR';
    protected $table = 'adenda_contratos_proveedor';
    protected $fillable = [
        'CONTRATO_ID',
        'FECHAI_ADENDA_CONTRATO',
        'FECHAF_ADENDA_CONTRATO',
        'COMENTARIO_ADENDA_CONTRATO',
        'DOCUMENTO_ADENDA_CONTRATO',
    ];
}
