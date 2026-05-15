<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altaproveedorModel extends Model
{
    use HasFactory;

    protected $table = 'formulario_altaproveedor';
    protected $primaryKey = 'ID_FORMULARIO_ALTA';
    protected $fillable = [
        'TIPO_PERSONA_ALTA',
        'RAZON_SOCIAL_ALTA',
        'REPRESENTANTE_LEGAL_ALTA',
        'RFC_ALTA',
        'REGIMEN_ALTA',
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
        'DOMICILIO_EXTRANJERO',
        'CODIGO_EXTRANJERO',
        'CIUDAD_EXTRANJERO',
        'ESTADO_EXTRANJERO',
        'PAIS_EXTRANJERO',
        'CORREO_DIRECTORIO',
        'TELEFONO_OFICINA_ALTA',
        'PAGINA_WEB_ALTA',
        'ACTIVIDAD_ECONOMICA',
        'CUAL_ACTVIDAD_ECONOMICA',
        'ACTVIDAD_COMERCIAL',
        'DESCUENTOS_ACTIVIDAD_ECONOMICA',
        'CUAL_DESCUENTOS_ECONOMICA',
        'DIAS_CREDITO_ALTA',
        'TERMINOS_IMPORTANCIAS_ALTA',
        'VINCULO_FAMILIAR',
        'DESCRIPCION_VINCULO',
        'SERVICIOS_PEMEX',
        'NUMERO_PROVEEDOR',
        'BENEFICIOS_PERSONA',
        'NOMBRE_PERSONA',
        'TIPO_PERSONA_OPCION',
        'VERIFICACION_SOLCITADA',
        'TIENE_ASIGNACION',
        'DOCUMENTOS_JSON',
        'PROVEEDOR_CRITICO',
        'PROVEEDOR_CONTRATO'

    ];
    
}
