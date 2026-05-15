<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaInteligencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('seleccion_inteligencia', function (Blueprint $table) {
            $table->increments('ID_INTELIGENCIA_SELECCION');    
            $table->text('CURP')->nullable();
            $table->text('ARCHIVO_COMPLETO')->nullable();
            $table->text('ARCHIVO_COMPETENCIAS')->nullable();
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
        //
    }
}
