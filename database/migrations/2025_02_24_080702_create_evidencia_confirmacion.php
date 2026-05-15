<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvidenciaConfirmacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencia_confirmacion', function (Blueprint $table) {
            $table->increments('ID_EVIDENCIA_CONFIRMACION');
            $table->integer('CONFIRMACION_ID')->nullable();
            $table->text('NOMBRE_EVIDENCIA')->nullable();
            $table->text('DOCUMENTO_EVIDENCIA')->nullable();
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
        Schema::dropIfExists('evidencia_confirmacion');
    }
}
