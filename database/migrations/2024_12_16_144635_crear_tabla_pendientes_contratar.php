<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPendientesContratar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendientes_contratar', function (Blueprint $table) {
            $table->increments('ID_PENDIENTES_CONTRATAR');
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_PC')->nullable();
            $table->text('PRIMER_APELLIDO_PC')->nullable();
            $table->text('SEGUNDO_APELLIDO_PC')->nullable();
            $table->text('CORREO_PC')->nullable();
            $table->text('TELEFONO1_PC')->nullable();
            $table->text('DIA_FECHA_PC')->nullable();
            $table->text('MES_FECHA_PC')->nullable();
            $table->text('ANIO_FECHA_PC')->nullable();
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
