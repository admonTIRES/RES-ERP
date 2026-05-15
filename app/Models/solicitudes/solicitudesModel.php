<?php

namespace App\Models\solicitudes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudesModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_SOLICITUDES';
    protected $table = 'formulario_solicitudes';
    protected $fillable = [
        'NO_SOLICITUD',
        'TIPO_SOLICITUD',
        'FECHA_SOLICITUD',
        'MEDIO_CONTACTO_SOLICITUD',
        'RAZON_SOCIAL_SOLICITUD',
        'NOMBRE_COMERCIAL_SOLICITUD',
        'GIRO_EMPRESA_SOLICITUD',
        'REPRESENTANTE_LEGAL_SOLICITUD',
        'DIRECCION_SOLICITUD',
        'CONTACTO_SOLICITUD',
        'CARGO_SOLICITUD',
        'TELEFONO_SOLICITUD',
        'CELULAR_SOLICITUD',
        'CORREO_SOLICITUD',
        'NECESIDAD_SERVICIO_SOLICITUD',
        'SERVICIO_SOLICITADO_SOLICITUD',
        'TIPO_CLIENTE_SOLICITUD',
        'OBSERVACIONES_SOLICITUD',
        'ESTATUS_SOLICITUD',
        'FECHA_NOTIFICACION_SOLICITUD',
        'ACTIVO',
        'DIRIGE_OFERTA',
        'CONTACTO_OFERTA',
        'CARGO_OFERTA',
        'TELEFONO_OFERTA',
        'CELULAR_OFERTA',
        'CORREO_OFERTA',
        'MOTIVO_RECHAZO',
        'RFC_SOLICITUD',
        'TIPO_SERVICIO_SOLICITUD',
        'CONTACTOS_JSON',
        'FECHA_CREACION_SOLICITUD',
        'LINEA_NEGOCIO_SOLICITUD',
        'SERVICIO_TERCERO',
        'DIRECCIONES_JSON',
        'EXTENSION_OFERTA',
        'RFC_EMPRESA',
        'RAZON_SOCIAL',
        'NOMBRE_COMERCIAL_EMPRESA',
        'GIRO_EMPRESA',
        'REPRESENTANTE_LEGAL_EMPRESA', 
        'TIPO_EMPRESA',
        'CODIGO_POSTAL',
        'TIPO_VIALIDAD_EMPRESA',
        'NOMBRE_VIALIDAD_EMPRESA',
        'NUMERO_EXTERIOR_EMPRESA',
        'NUMERO_INTERIOR_EMPRESA',
        'NOMBRE_COLONIA_EMPRESA',
        'NOMBRE_LOCALIDAD_EMPRESA',
        'NOMBRE_MUNICIPIO_EMPRESA',
        'NOMBRE_ENTIDAD_EMPRESA',
        'PAIS_EMPRESA',
        'ENTRE_CALLE_EMPRESA',
        'ENTRE_CALLE2_EMPRESA',
        'SOLICITAR_VERIFICACION',
        'PROCEDE_COTIZAR',
        'MOTIVO_COTIZACION',
        'DIRECCION_SOLICITUDES',
        'TITULO_CONTACTO_SOLICITUD',
        'NOMBRE_CONTACTO_SOLICITUD',
        'EXTENSION_SOLICITUD',
        'TITULO_OFERTA',
        'SELECTOR_DIRECCION',
        'SELECTOR_CONTACTO',
        'MISMA_DIRRECCION'
    ];

}
