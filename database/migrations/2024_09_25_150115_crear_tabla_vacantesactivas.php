<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaVacantesactivas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacantes_activas', function (Blueprint $table) {
            $table->increments('ID_VACANTES_ACTIVAS');
            $table->integer('VACANTES_ID')->nullable();
            $table->text('NOMBRE_AC')->nullable();
            $table->text('PRIMER_APELLIDO_AC')->nullable();
            $table->text('SEGUNDO_APELLIDO_AC')->nullable();
            $table->text('CORREO_AC')->nullable();
            $table->text('TELEFONO1_AC')->nullable();
            $table->text('TELEFONO2_AC')->nullable();
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
