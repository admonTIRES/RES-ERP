<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechasActualizaciondocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechas_actualizaciondocs', function (Blueprint $table) {
            $table->increments('ID_ACTUALIZACION_DOCUMENTOS');
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
        Schema::dropIfExists('fechas_actualizaciondocs');
    }
}
