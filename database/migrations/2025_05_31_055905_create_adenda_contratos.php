<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdendaContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adenda_contratos', function (Blueprint $table) {
            $table->increments('ID_ADENDA_CONTRATO');
            $table->integer('CONTRATO_ID')->nullable();
            $table->date('FECHAI_ADENDA_CONTRATO')->nullable();
            $table->date('FECHAF_ADENDA_CONTRATO')->nullable();
            $table->text('COMENTARIO_ADENDA_CONTRATO')->nullable();
            $table->text('DOCUMENTO_ADENDA_CONTRATO')->nullable();
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
        Schema::dropIfExists('adenda_contratos');
    }
}
