<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioRequerimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_requerimientos', function (Blueprint $table) {
            $table->increments('ID_FORMULARO_REQUERIMIENTO');
            $table->date('FECHA_RP')->nullable();
            $table->text('PRIORIDAD_RP')->nullable();
            $table->text('TIPO_VACANTE_RP')->nullable();
            $table->text('MOTIVO_VACANTE_RP')->nullable();
            $table->text('SUSTITUYE_RP')->nullable();
            $table->text('CENTRO_COSTO_RP')->nullable();
            $table->text('AREA_RP')->nullable();
            $table->text('NO_VACANTES_RP')->nullable();
            $table->text('PUESTO_RP')->nullable();
            $table->date('FECHA_INICIO_RP')->nullable();
            $table->text('OBSERVACION1_RP')->nullable();
            $table->text('OBSERVACION2_RP')->nullable();
            $table->text('OBSERVACION3_RP')->nullable();
            $table->text('OBSERVACION4_RP')->nullable();
            $table->text('OBSERVACION5_RP')->nullable();
            $table->text('CORREO_CORPORATIVO_RP')->nullable();
            $table->text('TELEFONO_CORPORATIVO_RP')->nullable();
            $table->text('SOFTWARE_RP')->nullable();
            $table->text('VEHICULO_EMPRESA_RP')->nullable();
            $table->text('SOLICITA_RP')->nullable();
            $table->text('AUTORIZA_RP')->nullable();            
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
        Schema::dropIfExists('formulario_requerimientos');
    }
}
