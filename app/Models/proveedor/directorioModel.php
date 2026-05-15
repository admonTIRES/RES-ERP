<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class directorioModel extends Model
{
    protected $primaryKey ='ID_FORMULARIO_DIRECTORIO';
    protected $table ='formulario_directorio';
    protected $fillable = [
        'RAZON_SOCIAL',
        'RFC_PROVEEDOR',
        'NOMBRE_COMERCIAL',
        'GIRO_PROVEEDOR',
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
        'NOMBRE_DIRECTORIO',
        'CARGO_DIRECTORIO',
        'TELEFONO_DIRECOTORIO',
        'EXSTENSION_DIRECTORIO',
        'CELULAR_DIRECTORIO',
        'SERVICIOS_JSON',
        'ACTIVO',
        'CONSTANCIA_DOCUMENTO',
        'CORREO_DIRECTORIO',
        'TIPO_PERSONA',
        'CIC_DIRECTORIO',
        'IDENTIFICADOR_DIRECTORIO',


        'DOMICILIO_EXTRANJERO',
        'CODIGO_EXTRANJERO',
        'CIUDAD_EXTRANJERO',
        'ESTADO_EXTRANJERO',
        'PAIS_EXTRANJERO',
        'DEPARTAMENTO_EXTRANJERO',
        'PROVEEDOR_VERIFICADO',
        'PROVEEDOR_CRITICO'
        
    ];
}
