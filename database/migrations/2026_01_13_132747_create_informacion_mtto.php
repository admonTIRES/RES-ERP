<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionMtto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_mtto', function (Blueprint $table) {
            $table->increments('ID_INFORMACION_MTTO');
            $table->integer('MANTENIMIENTO_ID')->nullable();
            $table->text('CRITERIO_MTTO')->nullable();
            $table->text('TIPO_MTTO')->nullable();
            $table->text('PROVEEDOR_INTEXT_MTTO')->nullable();
            $table->text('PROVEEDOR_INTERNO_MTTO')->nullable();
            $table->text('PROVEEDOR_EXTERNO_MTTO')->nullable();
            $table->date('FECHA_ULTIMO_MTTO')->nullable();
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
        Schema::dropIfExists('informacion_mtto');
    }
}
