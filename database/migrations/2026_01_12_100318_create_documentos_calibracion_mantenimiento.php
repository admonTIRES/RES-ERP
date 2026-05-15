<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosCalibracionMantenimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_calibracion_mantenimiento', function (Blueprint $table) {
            $table->increments('ID_DOCUMENTO_CALIBRACION');
            $table->integer('MANTENIMIENTO_ID')->nullable();
            $table->text('NOMBRE_DOCUMENTO_CALIBRACION')->nullable();
            $table->date('FECHAI_DOCUMENTO_CALIBRACION')->nullable();
            $table->date('FECHAF_DOCUMENTO_CALIBRACION')->nullable();
            $table->text('DADO_ALTA_CALIBRACION')->nullable();
            $table->text('PROVEEDOR_CALIBRACION')->nullable();
            $table->text('NOMBRE_PROVEEDOR_CALIBRACION')->nullable();
            $table->text('DOCUMENTO_CALIBRACION')->nullable();
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
        Schema::dropIfExists('documentos_calibracion_mantenimiento');
    }
}
