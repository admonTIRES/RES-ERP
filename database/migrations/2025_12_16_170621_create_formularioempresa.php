<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioempresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formularioempresa', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_EMPRESA');
            $table->text('RFC_EMPRESA')->nullable();
            $table->text('RAZON_SOCIAL')->nullable();
            $table->text('NOMBRE_COMERCIAL')->nullable();
            $table->text('REGIMEN_CAPITAL')->nullable();
            $table->text('CONTACTOS_JSON')->nullable();
            $table->text('DIRECCIONES_JSON')->nullable();
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
        Schema::dropIfExists('formularioempresa');
    }
}
