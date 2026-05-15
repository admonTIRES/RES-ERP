<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetenciaFieldsToFormularioDptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_dpt', function (Blueprint $table) {
            $table->text('NOMBRE_COMPETENCIA1')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA1')->nullable();
            $table->text('COMPETENCIA1_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA2')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA2')->nullable();
            $table->text('COMPETENCIA2_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA3')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA3')->nullable();
            $table->text('COMPETENCIA3_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA4')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA4')->nullable();
            $table->text('COMPETENCIA4_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA5')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA5')->nullable();
            $table->text('COMPETENCIA5_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA6')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA6')->nullable();
            $table->text('COMPETENCIA6_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA7')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA7')->nullable();
            $table->text('COMPETENCIA7_ESCALA')->nullable();
            $table->text('NOMBRE_COMPETENCIA8')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA8')->nullable();
            $table->text('COMPETENCIA8_ESCALA')->nullable();
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
