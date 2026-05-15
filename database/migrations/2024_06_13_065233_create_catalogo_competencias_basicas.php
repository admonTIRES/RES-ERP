<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoCompetenciasBasicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_competencias_basicas', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_COMPETENCIA_BASICA');
            $table->text('NOMBRE_COMPETENCIA_BASICA')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA_BASICA')->nullable();
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
        Schema::dropIfExists('catalogo_competencias_basicas');
    }
}
