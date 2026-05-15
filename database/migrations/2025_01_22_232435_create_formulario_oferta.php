<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioOferta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_ofertas', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_OFERTAS');
            $table->integer('SOLICITUD_ID')->nullable();
            $table->text('NO_OFERTA')->nullable();
            $table->text('REVISION_OFERTA')->nullable();
            $table->date('FECHA_OFERTA')->nullable();
            $table->text('TIEMPO_OFERTA')->nullable();
            $table->text('SERVICIO_COTIZADO_OFERTA')->nullable();
            $table->text('MONEDA_MONTO')->nullable();
            $table->text('IMPORTE_OFERTA')->nullable();
            $table->text('DIAS_VALIDACION_OFERTA')->nullable();
            $table->text('OBSERVACIONES_OFERTA')->nullable();
            $table->text('MOTIVO_RECHAZO')->nullable();
            $table->text('ACEPTADA_OFERTA')->nullable();
            $table->date('FECHA_ACEPTACION_OFERTA')->nullable();
            $table->date('FECHA_FIRMA_OFERTA')->nullable();
            $table->text('ESTATUS_OFERTA')->nullable();
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
        Schema::dropIfExists('formulario_ofertas');
    }
}
