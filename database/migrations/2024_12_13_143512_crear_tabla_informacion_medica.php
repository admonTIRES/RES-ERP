<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaInformacionMedica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_medica_contrato', function (Blueprint $table) {
            $table->increments('ID_INFORMACION_MEDICA');
            $table->integer('CONTRATO_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_DOCUMENTO_INFORMACION')->nullable();
            $table->text('DOCUMENTO_INFORMACION_MEDICA')->nullable();
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
