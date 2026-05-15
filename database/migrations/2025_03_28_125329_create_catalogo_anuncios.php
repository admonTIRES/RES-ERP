<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoAnuncios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_anuncios', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_ANUNCIOS');
            $table->text('DESCRIPCION_ANUNCIO')->nullable();
            $table->text('TIPO_REPETICION')->nullable();
            $table->date('FECHA_INICIO')->nullable();
            $table->date('FECHA_FIN')->nullable();
            $table->time('HORA_INICIO')->nullable();
            $table->time('HORA_FIN')->nullable();
            $table->date('FECHA_ANUAL')->nullable();
            $table->time('HORA_ANUAL_INICIO')->nullable();
            $table->time('HORA_ANUAL_FIN')->nullable();
            $table->text('MES_MENSUAL')->nullable();
            $table->text('FOTO_ANUNCIO')->nullable();
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
        Schema::dropIfExists('catalogo_anuncios');
    }
}
