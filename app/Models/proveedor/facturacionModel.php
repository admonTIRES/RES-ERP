<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facturacionModel extends Model
{
    use HasFactory;
    protected $table = 'formulario_facturasproveedores';
    protected $primaryKey = 'ID_FORMULARIO_FACTURACION';
    protected $fillable = [
        'NO_CONTRATO',
        'RFC_PROVEEDOR',
        'TIPO_FACTURA',
        'NO_PO',
        'NO_GR',
        'DOCUMENTOS_SOPORTE_FACTURA',
        'FACTURA_PDF',
        'FACTURA_XML',
        'FOLIO_FISCAL',
        'FECHA_FACTURA',
        'METODO_PAGO',
        'MONEDA_FACTURA',
        'SUBTOTAL_FACTURA',
        'IVA_FACTURA',
        'TOTAL_FACTURA',
        'NO_FACTURA_EXTRANJERO',
        'FECHA_FACTURA_EXTRANJERO',
        'MONEDA_FACTURA_EXTRANJERO',
        'SUBTOTAL_FACTURA_EXTRANJERO',
        'IVA_FACTURA_EXTRANJERO',
        'TOTAL_FACTURA_EXTRANJERO',
        'ACTIVO',

        //// NUEVOS  CAMPOS ////

        'ESTATUS_FACTURA',
        'SUBIR_REP',
        'ARCHIVO_REP',
        'XML_REP',
        'ESTATUS_REP',

        'SUBIR_RECIBO_PAGO',
        'ARCHIVO_RECIBO_PAGO',


        'MOTIVO_RECHAZO_FACTURA'


    ];
}
