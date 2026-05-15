<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaReferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleccion_referencias_laboral', function (Blueprint $table) {
            $table->increments('ID_REFERENCIAS_SELECCION');    
            $table->text('CURP')->nullable();
            $table->text('EXPERIENCIA_LABORAL')->nullable();
            $table->text('PORCENTAJE_TOTAL_REFERENCIAS')->nullable();
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
