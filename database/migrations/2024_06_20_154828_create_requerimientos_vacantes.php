<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimientosVacantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimientos_vacantes', function (Blueprint $table) {
            $table->increments('ID_REQUERIMIENTOS_VACANTES');
            $table->integer('CATALOGO_VACANTES_ID')->nullable();
            $table->text('NOMBRE_REQUERIMINETO')->nullable();
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
        Schema::dropIfExists('requerimientos_vacantes');
    }
}
