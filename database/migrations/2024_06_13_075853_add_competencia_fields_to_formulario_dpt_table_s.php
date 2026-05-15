<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetenciaFieldsToFormularioDptTableS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_dpt', function (Blueprint $table) {
            $table->text('NOMBRE_COMPETENCIA11')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA11')->nullable();
            $table->text('COMPETENCIA11_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA12')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA12')->nullable();
            $table->text('COMPETENCIA12_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA13')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA13')->nullable();
            $table->text('COMPETENCIA13_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA14')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA14')->nullable();
            $table->text('COMPETENCIA14_ESCALA')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulario_dpt', function (Blueprint $table) {
            //
        });
    }
}
