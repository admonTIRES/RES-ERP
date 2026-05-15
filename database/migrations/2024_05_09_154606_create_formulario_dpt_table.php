<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioDptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_dpt', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_DPT');
            $table->integer('DEPARTAMENTOS_AREAS_ID')->nullable();
            $table->text('AREA_TRABAJO_DPT')->nullable();
            $table->text('PROPOSITO_FINALIDAD_DPT')->nullable();
            $table->text('NIVEL_JERARQUICO_DPT')->nullable();
            $table->text('PUESTO_REPORTA_DPT')->nullable();
            $table->text('PUESTO_LE_REPORTAN_DPT')->nullable();
            $table->text('PUESTOS_INTERACTUAN_DPT')->nullable();
            $table->text('PUESTOS_DIRECTOS_DPT')->nullable();
            $table->text('LUGAR_TRABAJO_DPT')->nullable();
            $table->text('DISPONIBILIDAD_VIAJAR')->nullable();
            $table->text('HORARIO_ENTRADA_DPT')->nullable();
            $table->text('HORARIO_SALIDA_DPT')->nullable();
            $table->text('FUNCIONES_CARGO_DPT')->nullable();
            $table->text('FUNCIONES_GESTION_DPT')->nullable();
            $table->text('ESCALA_INNOVACION')->nullable();
            $table->text('ESCALA_PASION')->nullable();
            $table->text('ESCALA_SERVICIO')->nullable();
            $table->text('ESCALA_COMUNICACION')->nullable();
            $table->text('ESCALA_TRABAJO')->nullable();
            $table->text('ESCALA_INTEGRIDAD')->nullable();
            $table->text('ESCALA_RESPONSABILIDAD')->nullable();
            $table->text('ESCALA_ADAPTIBILIDAD')->nullable();
            $table->text('ESCALA_LIDERAZGO')->nullable();
            $table->text('ESCALA_TOMADECISION')->nullable();
            $table->text('DE_INFORMACION_SI_DPT')->nullable();
            $table->text('DE_INFORMACION_NO_DPT')->nullable();
            $table->text('DE_RECURSOS_SI_DPT')->nullable();
            $table->text('DE_RECURSOS_NO_DPT')->nullable();
            $table->text('DE_INFORMACION_ESPECIFIQUE_DPT')->nullable();
            $table->text('DE_RECURSOS_ESPECIFIQUE_DPT')->nullable();
            $table->text('DE_EQUIPOS_SI_DPT')->nullable();
            $table->text('DE_EQUIPOS_NO_DPT')->nullable();
            $table->text('DE_VEHICULOS_SI_DPT')->nullable();
            $table->text('DE_VEHICULOS_NO_DPT')->nullable();
            $table->text('DE_EQUIPOS_ESPECIFIQUE_DPT')->nullable();
            $table->text('DE_VEHICULOS_ESPECIFIQUE_DPT')->nullable();
            $table->text('OBSERVACIONES_DPT')->nullable();
            $table->text('ORGANIGRAMA_DPT')->nullable();
            $table->text('ELABORADO_NOMBRE_DPT')->nullable();
            $table->text('ELABORADO_FIRMA_DPT')->nullable();
            $table->date('ELABORADO_FECHA_DPT')->nullable();
            $table->text('REVISADO_NOMBRE_DPT')->nullable();
            $table->text('REVISADO_FIRMA_DPT')->nullable();
            $table->date('REVISADO_FECHA_DPT')->nullable();
            $table->text('AUTORIZADO_NOMBRE_DPT')->nullable();
            $table->text('AUTORIZADO_FIRMA_DPT')->nullable();
            $table->date('AUTORIZADO_FECHA_DPT')->nullable();
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
        Schema::dropIfExists('formulario_dpt');
    }
}
