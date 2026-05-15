<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacitacionEvidenciageneradas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_evidenciageneradas', function (Blueprint $table) {
            $table->increments('ID_EVIDENCIA_GENERADAS');
            $table->text('NOMBRE_EVIDENCIA')->nullable();
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
        Schema::dropIfExists('capacitacion_evidenciageneradas');
    }
}
