<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacorasalmacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacorasalmacen', function (Blueprint $table) {
            $table->increments('ID_BITACORAS_ALMACEN');
            $table->text('SOLICITANTE_SALIDA')->nullable();
            $table->date('FECHA_SALIDA')->nullable();
            $table->text('DESCRIPCION')->nullable();
            $table->text('CANTIDAD')->nullable();
            $table->text('CANTIDAD_SALIDA')->nullable();
            $table->text('INVENTARIO')->nullable();
            $table->text('FUNCIONAMIENTO_BITACORA')->nullable();
            $table->text('OBSERVACIONES_REC')->nullable();
            $table->text('RECIBIDO_POR')->nullable();
            $table->text('ENTREGADO_POR')->nullable();
            $table->text('FIRMA_RECIBIDO_POR')->nullable();
            $table->text('FIRMA_ENTREGADO_POR')->nullable();
            $table->text('OBSERVACIONES_BITACORA')->nullable();
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
        Schema::dropIfExists('bitacorasalmacen');
    }
}
