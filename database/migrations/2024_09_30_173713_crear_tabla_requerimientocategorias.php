<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRequerimientocategorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimientos_categorias', function (Blueprint $table) {
            $table->increments('ID_REQUERIMIENTOS_CATEGORIAS');
            $table->integer('CATALOGO_CATEGORIAS_ID')->nullable();
            $table->text('TIPO_PRUEBA')->nullable();
            $table->text('PORCENTAJE')->nullable();
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
