<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaIncidenciasContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias_contrato', function (Blueprint $table) {
            $table->increments('ID_INCIDENCIAS');
            $table->integer('CONTRATO_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_DOCUMENTO_INCIDENCIAS')->nullable();
            $table->text('DOCUMENTO_INCIDENCIAS')->nullable();
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
