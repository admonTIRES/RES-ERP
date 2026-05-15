<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificacionSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificacion_solicitud', function (Blueprint $table) {
            $table->increments('ID_VERIFICACION_SOLICITUD');
            $table->integer('SOLICITUD_ID')->nullable();
            $table->text('VERIFICADO_EN')->nullable();
            $table->text('EVIDENCIA_VERIFICACIO')->nullable();
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
        Schema::dropIfExists('verificacion_solicitud');
    }
}
