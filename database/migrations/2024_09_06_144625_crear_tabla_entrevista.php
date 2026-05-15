<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaEntrevista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleccion_entrevista', function (Blueprint $table) {
            $table->increments('ID_ENTREVISTA_SELECCION');
            $table->text('COMENTARIO_ENTREVISTA')->nullable();          
            $table->text('ARCHIVO_ENTREVISTA')->nullable();
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
