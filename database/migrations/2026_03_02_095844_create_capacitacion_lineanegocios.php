<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacitacionLineanegocios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_lineanegocios', function (Blueprint $table) {
            $table->increments('ID_LINEA_NEGOCIO');
            $table->text('NOMBRE_LINEA')->nullable();
            $table->text('ABREVIATURA_NEGOCIO')->nullable();
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
        Schema::dropIfExists('capacitacion_lineanegocios');
    }
}
