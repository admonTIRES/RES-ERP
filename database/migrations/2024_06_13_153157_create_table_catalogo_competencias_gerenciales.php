<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCatalogoCompetenciasGerenciales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('catalogo_competencias_gerenciales', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_COMPETENCIA_GERENCIAL');
            $table->text('NOMBRE_COMPETENCIA_GERENCIAL')->nullable();
            $table->text('DESCRIPCION_COMPETENCIA_GERENCIAL')->nullable();
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
        Schema::dropIfExists('catalogo_competencias_gerenciales');
    }
}
