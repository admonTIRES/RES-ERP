<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaLABORAL extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referencias_seleccion_laboral', function (Blueprint $table) {
            $table->increments('ID_LABORAL_SELECCION');
            $table->integer('SELECCION_REFERENCIA_ID')->nullable();
            $table->text('NOMBRE_EMPRESA')->nullable();
            $table->text('COMENTARIO')->nullable();
            $table->text('CUMPLE')->nullable();
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
