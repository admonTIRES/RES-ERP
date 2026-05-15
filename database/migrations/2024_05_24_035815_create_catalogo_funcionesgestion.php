<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoFuncionesgestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_funcionesgestiones', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_FUNCIONESGESTION');
            $table->text('TIPO_FUNCION_GESTION')->nullable();
            $table->text('CATEGORIAS_GESTION')->nullable();
            $table->text('DESCRIPCION_FUNCION_GESTION')->nullable();
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
        Schema::dropIfExists('catalogo_funcionesgestiones');
    }
}
