<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablaasignacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones_inventario', function (Blueprint $table) {
            $table->increments('ID_ASIGNACION_FORMULARIO');
            $table->integer('ASIGNADO_ID');
            $table->integer('INVENTARIO_ID');
            $table->date('FECHA_ASIGNACION')->nullable();
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
        Schema::dropIfExists('asignaciones_inventario');
    }
}
