<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificacionCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificacion_cliente', function (Blueprint $table) {
            $table->increments('ID_VERIFICACION_CLIENTE');
            $table->integer('CLIENTE_ID')->nullable();
            $table->text('VERIFICADO_EN')->nullable();
            $table->text('EVIDENCIA_VERIFICACION')->nullable();
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
        Schema::dropIfExists('verificacion_cliente');
    }
}
