<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventarioModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_INVENTARIO';
    protected $table = 'formulario_inventario';
    protected $fillable = [

        'FOTO_EQUIPO',
        'DESCRIPCION_EQUIPO',
        'MARCA_EQUIPO',
        'MODELO_EQUIPO',
        'SERIE_EQUIPO',
        'CODIGO_EQUIPO',
        'CANTIDAD_EQUIPO',
        'UBICACION_EQUIPO',
        'ESTADO_EQUIPO',
        'FECHA_ADQUISICION',
        'PROVEEDOR_EQUIPO',
        'UNITARIO_EQUIPO',
        'TOTAL_EQUIPO',
        'TIPO_EQUIPO',
        'ACTIVO',
        'OBSERVACION_EQUIPO',
        'UNIDAD_MEDIDA',
        'REQUIERE_ARTICULO',
        'LIMITEMINIMO_EQUIPO',
        'ITEM_CRITICO',
        'PLACAS_VEHICULOS',
        'COLOR_VEHICULO',
        'NUMERO_POLIZA',
        'ASIGNADO',
        'ENTIDAD_POLIZA',
        'INICIOVIGENCIA_POLIZA',
        'FINVIGENCIA_POLIZA',
        'PROVEEDOR_ALTA',
        'NOMBRE_PROVEEDOR', 
        'REQUIERE_CALIBRACION',
        'ES_INFRAESTRUCTURA',
        'DETALLAR_ARTICULOS',

        'FRENTE_DERECHA',
        'FRENTE_IZQUIERDA',
        'TRASERA_DERECHA',
        'TRASERA_IZQUIERDA'

    ];
}
