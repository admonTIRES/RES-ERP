<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaSeleccionPrueba extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleccion_prueba_conocimiento', function (Blueprint $table) {
            $table->increments('ID_PRUEBAS_SELECCION');    
            $table->text('CURP')->nullable();
            $table->text('REQUIERE_PRUEBAS')->nullable();
            $table->text('PORCENTAJE_TOTAL_PRUEBA')->nullable();
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
