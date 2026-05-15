<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioRecempleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_recempleados', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_RECURSOS_EMPLEADOS');
            $table->integer('USUARIO_ID');
            $table->text('TIPO_SOLICITUD')->nullable();
            $table->text('SOLICITANTE_SALIDA')->nullable();
            $table->date('FECHA_SALIDA')->nullable();
            $table->text('MATERIAL_RETORNA_SALIDA')->nullable();
            $table->date('FECHA_ESTIMADA_SALIDA')->nullable();
            $table->text('MATERIALES_JSON')->nullable();
            $table->text('SOLICITANTE_PERMISO')->nullable();
            $table->date('FECHA_PERMISO')->nullable();
            $table->text('CARGO_PERMISO')->nullable();
            $table->text('NOEMPLEADO_PERMISO')->nullable();
            $table->text('CONCEPTO_PERMISO')->nullable();
            $table->text('NODIAS_PERMISO')->nullable();
            $table->text('NOHORAS_PERMISO')->nullable();
            $table->date('FECHA_INICIAL_PERMISO')->nullable();
            $table->date('FECHA_FINAL_PERMISO')->nullable();
            $table->text('EXPLIQUE_PERMISO')->nullable();
            $table->text('OBSERVACIONES_REC')->nullable();
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
        Schema::dropIfExists('formulario_recempleados');
    }
}
