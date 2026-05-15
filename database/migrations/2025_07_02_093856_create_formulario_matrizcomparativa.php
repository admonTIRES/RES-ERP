<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioMatrizcomparativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_matrizcomparativa', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_MATRIZ');
            $table->integer('HOJA_ID')->nullable();
            $table->boolean('ACTIVO')->default(1);
            $table->text('MATERIALES_JSON')->nullable();

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
        Schema::dropIfExists('formulario_matrizcomparativa');
    }
}
