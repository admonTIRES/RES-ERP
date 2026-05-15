<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidasInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas_inventario', function (Blueprint $table) {
            $table->increments('ID_SALIDA_FORMULARIO');
            $table->integer('USUARIO_ID');
            $table->integer('INVENTARIO_ID');
            $table->date('FECHA_SALIDA')->nullable();
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
        Schema::dropIfExists('salidas_inventario');
    }
}
