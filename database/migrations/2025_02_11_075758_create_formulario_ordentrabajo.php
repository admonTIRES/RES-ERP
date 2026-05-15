<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioOrdentrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_ordentrabajo', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_ORDEN');
            $table->text('NO_OFERTA')->nullable();
            $table->text('NO_ORDEN_CONFIRMACION')->nullable();
            $table->date('FECHA_EMISION')->nullable();
            $table->text('VERIFICADO_POR')->nullable();
            $table->date('FECHA_VERIFICACION')->nullable();
            $table->text('PRIORIDAD_SERVICIO')->nullable();
            $table->date('FECHA_INICIO_SERVICIO')->nullable();
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
        Schema::dropIfExists('formulario_ordentrabajo');
    }
}
