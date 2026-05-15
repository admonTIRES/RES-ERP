<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacitacionCursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_cursos', function (Blueprint $table) {

            $table->increments('ID_CURSOS_CAPACITACION');

            // TEXT
            $table->text('TIPO_ID')->nullable();
            $table->text('NUMERO_ID')->nullable();
            $table->text('NOMBE_OFICIAL_CURSO')->nullable();
            $table->text('NOMBE_COMERCIAL_CURSO')->nullable();
            $table->text('DESCRIPCION_CURSO')->nullable();
            $table->text('OBJETIVOS_CURSO')->nullable();
            $table->text('DURACION_CURSO')->nullable();
            $table->text('HORAS_TEORICAS')->nullable();
            $table->text('HORAS_PRACTICAS')->nullable();
            $table->text('NUMERO_SESIONES')->nullable();
            $table->text('DURACION_SESIONES')->nullable();
            $table->text('PERFILRECOMENDADO_CURSO')->nullable();
            $table->text('ESCOLARIDAD_CURSO')->nullable();
            $table->text('EXPERIENCIA_CURSO')->nullable();
            $table->text('CURSOS_PREVIOS')->nullable();
            $table->text('RIESGOSRELACIONADOS_CURSO')->nullable();
            $table->text('PRESTACIONSERVICIOS_CURSO')->nullable();
            $table->text('NOMBRE_INSTRUCTOR')->nullable();
            $table->text('CERTIFICACIONES_INSTRUCTOR')->nullable();
            $table->text('NOMBRE_PROVEEDOR')->nullable();
            $table->text('UBICACION_PROVEEDOR')->nullable();
            $table->text('CONTACTO_CONTRATO_PROVEEDOR')->nullable();
            $table->text('CRITERIOS_APROBACION')->nullable();
            $table->text('CALIFICACION_MINIMA')->nullable();
            $table->text('VIGENCIA_CURSO')->nullable();
            $table->text('CADA_CUANTO_TIEMPO')->nullable();
            $table->text('COSTO_INTERNO')->nullable();
            $table->text('COSTO_EXTERNO')->nullable();
            $table->text('MONEDA_CURSO')->nullable();
            $table->text('VIATICOS_CURSO')->nullable();
            $table->text('MATERIALES_CURSO')->nullable();
            $table->text('LICENCIAS_CURSO')->nullable();
            $table->text('COSTO_PARTICIPANTE')->nullable();
            $table->text('BAJO_DEMANDA')->nullable();
            $table->text('PROGRAMADO_CADACUANTO')->nullable();
            $table->text('CAPACIDAD_MINIMA')->nullable();
            $table->text('CAPACIDAD_MAXIMA')->nullable();
            $table->text('VERSION_CURSO')->nullable();
            $table->text('ESTATUS_CURSO')->nullable();
            $table->text('EVALUACION_CURSO')->nullable();
            $table->text('EVALUACION_INSTRUCTOR')->nullable();
            $table->text('LECCIONES_APRENDIDAS')->nullable();
            $table->text('OBSERVACIONES_CURSO')->nullable();

            // LONGTEXT
            $table->longText('CATEGORIAS_CURSO')->nullable();
            $table->longText('TIPO_CURSO')->nullable();
            $table->longText('AREA_CONOCIMIENTO')->nullable();
            $table->longText('NIVELES_CURSO')->nullable();
            $table->longText('MODALIDAD_CURSO')->nullable();
            $table->longText('FORMATO_CURSO')->nullable();
            $table->longText('PAISREGION_CURSO')->nullable();
            $table->longText('IDIOMAS_CURSO')->nullable();
            $table->longText('NORMATIVA_CURSO')->nullable();
            $table->longText('RECONOCIMIENTO_CURSO')->nullable();
            $table->longText('COMPETENCIAS_CURSO')->nullable();
            $table->longText('TIPO_PROVEEDOR')->nullable();
            $table->longText('METODO_EVALUACION')->nullable();
            $table->longText('EVIDENCIAS_GENERADAS')->nullable();
            $table->longText('DOCUMENTOS_EMITIDOS')->nullable();
            $table->longText('UBICACION_CURSO')->nullable();
            $table->longText('MATERIAL_DIDACTICO')->nullable();
            $table->longText('IMPACTO_ESPERADO')->nullable();
            $table->boolean('ACTIVO')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capacitacion_cursos');
    }
}
