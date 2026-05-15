<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaContratosAnexoContratacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos_anexos_contratacion', function (Blueprint $table) {
            $table->increments('ID_CONTRATOS_ANEXOS');
            $table->text('CURP')->nullable();
            $table->text('TIPO_DOCUMENTO_CONTRATO')->nullable();
            $table->text('NOMBRE_DOCUMENTO_CONTRATO')->nullable();
            $table->text('NOMBRE_CARGO')->nullable();
            $table->date('VIGENCIA_CONTRATO')->nullable();
            $table->date('VIGENCIA_ACUERDO')->nullable();
            $table->text('DOCUMENTO_CONTRATO')->nullable();
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
