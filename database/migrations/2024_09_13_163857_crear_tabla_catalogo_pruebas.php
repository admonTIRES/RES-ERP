<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaCatalogoPruebas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_pruebas_conocimientos', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_PRUEBA_CONOCIMIENTO');
            $table->text('NOMBRE_PRUEBA')->nullable();
            $table->text('DESCRIPCION_PRUEBA')->nullable();
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
