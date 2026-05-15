<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaDocumentosSoporteContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_soporte_contrato', function (Blueprint $table) {
            $table->increments('ID_SOPORTE_CONTRATO');
            $table->integer('CONTRATO_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('TIPO_DOCUMENTOSOPORTECONTRATO')->nullable();
            $table->text('NOMBRE_DOCUMENTOSOPORTECONTRATO')->nullable();
            $table->text('DOCUMENTOS_SOPORTECONTRATOS')->nullable();
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
