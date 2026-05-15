<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPruebasSeleccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referencias_seleccion_pruebas', function (Blueprint $table) {
            $table->increments('ID_REFERENCIASPRUEBAS_SELECCION');
            $table->integer('SELECCION_PRUEBAS_ID')->nullable();
            $table->text('TIPO_PRUEBA')->nullable();
            $table->text('PORCENTAJE_PRUEBA')->nullable();
            $table->text('TOTAL_PORCENTAJE')->nullable();
            $table->text('ARCHIVO_RESULTADO')->nullable();
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
