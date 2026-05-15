<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradasInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas_inventario', function (Blueprint $table) {
            $table->increments('ID_ENTRADA_FORMULARIO');
            $table->integer('INVENTARIO_ID')->nullable();
            $table->date('FECHA_INGRESO')->nullable();
            $table->text('DETALLE_OPERACION')->nullable();
            $table->text('CANTIDAD_PRODUCTO')->nullable();
            $table->text('VALOR_UNITARIO')->nullable();
            $table->text('COSTO_TOTAL')->nullable();
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
        Schema::dropIfExists('entradas_inventario');
    }
}
