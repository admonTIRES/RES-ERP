<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaSeleccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_seleccion', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_SELECCION');
            $table->integer('VACANTES_ID')->nullable();
            $table->text('NOMBRE_SELC')->nullable();
            $table->text('PRIMER_APELLIDO_SELEC')->nullable();
            $table->text('SEGUNDO_APELLIDO_SELEC')->nullable();
            $table->text('CORREO_SELEC')->nullable();
            $table->text('TELEFONO1_SELECT')->nullable();
            $table->text('TELEFONO2_SELECT')->nullable();
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
