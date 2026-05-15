<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRenovacionContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renovacion_contrato', function (Blueprint $table) {
            $table->increments('ID_RENOVACION_CONTATO');
            $table->integer('CONTRATO_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_DOCUMENTO_RENOVACION')->nullable();
            $table->date('FECHAI_RENOVACION')->nullable();
            $table->date('FECHAF_RENOVACION')->nullable();
            $table->text('SALARIO_RENOVACION')->nullable();
            $table->text('DOCUMENTOS_RENOVACION')->nullable();
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
