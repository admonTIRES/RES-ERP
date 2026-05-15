<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechaActualizaciondocsproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fecha_actualizaciondocsproveedor', function (Blueprint $table) {
            $table->increments('ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR');
            $table->date('FECHA_INICIO')->nullable();
            $table->date('FECHA_FIN')->nullable();
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
        Schema::dropIfExists('fecha_actualizaciondocsproveedor');
    }
}
