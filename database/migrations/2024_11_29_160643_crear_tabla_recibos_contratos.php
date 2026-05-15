<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRecibosContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_contrato', function (Blueprint $table) {
            $table->increments('ID_RECIBOS_NOMINA');
            $table->integer('CONTRATO_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_RECIBO')->nullable();
            $table->date('FECHA_RECIBO')->nullable();
            $table->text('DOCUMENTO_RECIBO')->nullable();
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
