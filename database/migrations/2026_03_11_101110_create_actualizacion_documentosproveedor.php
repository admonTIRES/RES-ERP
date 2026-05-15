<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualizacionDocumentosproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actualizacion_documentosproveedor', function (Blueprint $table) {
            $table->increments('ID_ACTUALIZACION_DOC');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('ID_DOCUMENTO_PROVEEDOR')->nullable();
            $table->text('ID_CATALOGO_DOCUMENTO')->nullable();
            $table->text('DOCUMENTO_NUEVO')->nullable();
            $table->text('ESTATUS')->nullable();
            $table->date('FECHA_SOLICITUD')->nullable();
            $table->text('VOBO_RH')->nullable();
            $table->text('AUTORIZACION_FINAL')->nullable();
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
        Schema::dropIfExists('actualizacion_documentosproveedor');
    }
}
