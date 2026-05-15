<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CvContratacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_contratacion', function (Blueprint $table) {
            $table->increments('ID_CV_CONTRATACION');
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_CV')->nullable();
            $table->text('CARGO_CV')->nullable();
            $table->text('PROFESION_CV')->nullable();
            $table->text('NACIONALIDAD_CV')->nullable();
            $table->text('FOTO_CV')->nullable();
            $table->text('DESCRIPCION_PERFIL_CV')->nullable();
            $table->text('FORMACION_ACADEMICA_CV')->nullable();
            $table->text('DOCUMENTO_ACADEMICOS_CV')->nullable();
            $table->text('REQUIERE_CEDULA_CV')->nullable();
            $table->text('ESTATUS_CEDULA_CV')->nullable();
            $table->text('NOMBRE_CEDULA_CV')->nullable();
            $table->text('NUMERO_CEDULA_CV')->nullable();
            $table->date('EMISION_CEDULA_CV')->nullable();
            $table->text('DOCUMENTO_CEDULA_CV')->nullable();
            $table->text('DOCUMENTO_VALCEDULA_CV')->nullable();
            $table->text('EXPERIENCIA_LABORAL_CV')->nullable();
            $table->text('EDUCACION_CONTINUA_CV')->nullable();
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
        //
    }
}
