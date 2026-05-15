<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cursosModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CURSOS_CAPACITACION';
    protected $table = 'capacitacion_cursos';
    protected $fillable = [

        'TIPO_ID',
        'NUMERO_ID',
        'NOMBE_OFICIAL_CURSO',
        'NOMBE_COMERCIAL_CURSO',
        'DESCRIPCION_CURSO',
        'OBJETIVOS_CURSO',
        'DURACION_CURSO',
        'HORAS_TEORICAS',
        'HORAS_PRACTICAS',
        'NUMERO_SESIONES',
        'DURACION_SESIONES',
        'PERFILRECOMENDADO_CURSO',
        'ESCOLARIDAD_CURSO',
        'EXPERIENCIA_CURSO',
        'CURSOS_PREVIOS',
        'RIESGOSRELACIONADOS_CURSO',
        'PRESTACIONSERVICIOS_CURSO',
        'NOMBRE_INSTRUCTOR',
        'CERTIFICACIONES_INSTRUCTOR',
        'NOMBRE_PROVEEDOR',
        'UBICACION_PROVEEDOR',
        'CONTACTO_CONTRATO_PROVEEDOR',
        'CRITERIOS_APROBACION',
        'CALIFICACION_MINIMA',
        'VIGENCIA_CURSO',
        'CADA_CUANTO_TIEMPO',
        'COSTO_INTERNO',
        'COSTO_EXTERNO',
        'MONEDA_CURSO',
        'VIATICOS_CURSO',
        'MATERIALES_CURSO',
        'LICENCIAS_CURSO',
        'COSTO_PARTICIPANTE',
        'BAJO_DEMANDA',
        'PROGRAMADO_CADACUANTO',
        'CAPACIDAD_MINIMA',
        'CAPACIDAD_MAXIMA',
        'VERSION_CURSO',
        'ESTATUS_CURSO',
        'EVALUACION_CURSO',
        'EVALUACION_INSTRUCTOR',
        'LECCIONES_APRENDIDAS',
        'OBSERVACIONES_CURSO',

        'CATEGORIAS_CURSO',
        'TIPO_CURSO',
        'AREA_CONOCIMIENTO',
        'NIVELES_CURSO',
        'MODALIDAD_CURSO',
        'FORMATO_CURSO',
        'PAISREGION_CURSO',
        'IDIOMAS_CURSO',
        'NORMATIVA_CURSO',
        'RECONOCIMIENTO_CURSO',
        'COMPETENCIAS_CURSO',
        'TIPO_PROVEEDOR',
        'METODO_EVALUACION',
        'EVIDENCIAS_GENERADAS',
        'DOCUMENTOS_EMITIDOS',
        'UBICACION_CURSO',
        'MATERIAL_DIDACTICO',
        'IMPACTO_ESPERADO',
        'CURSOS_JSON',
        'PRESTACION_SERVICIO_JSON',
        'CERTIFICACIONES_INSTRUCTOR_JSON',
        'CALIFICACION_MAXIMA',
        'TIPO_COSTO',
        'COSTO_CURSO',
        'TASA_CAMBIO',
        'VALOR_MXN',
        'ACTIVO'
    ];


    protected $casts = [

        'CATEGORIAS_CURSO' => 'array',
        'TIPO_CURSO' => 'array',
        'AREA_CONOCIMIENTO' => 'array',
        'NIVELES_CURSO' => 'array',
        'MODALIDAD_CURSO' => 'array',
        'FORMATO_CURSO' => 'array',
        'PAISREGION_CURSO' => 'array',
        'IDIOMAS_CURSO' => 'array',
        'NORMATIVA_CURSO' => 'array',
        'RECONOCIMIENTO_CURSO' => 'array',
        'COMPETENCIAS_CURSO' => 'array',
        'TIPO_PROVEEDOR' => 'array',
        'METODO_EVALUACION' => 'array',
        'EVIDENCIAS_GENERADAS' => 'array',
        'DOCUMENTOS_EMITIDOS' => 'array',
        'UBICACION_CURSO' => 'array',
        'MATERIAL_DIDACTICO' => 'array',
        'IMPACTO_ESPERADO' => 'array',
        
    ];
 
    }
