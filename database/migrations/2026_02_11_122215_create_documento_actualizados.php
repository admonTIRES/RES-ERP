<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoActualizados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_actualizados', function (Blueprint $table) {
            $table->increments('ID_DOCUMENTOS_ACTUALIZADOS');
            $table->text('DOCUMENTOS_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_DOCUMENTO')->nullable();
            $table->text('PROCEDE_FECHA_DOC')->nullable();
            $table->date('FECHAI_DOCUMENTOSOPORTE')->nullable();
            $table->date('FECHAF_DOCUMENTOSOPORTE')->nullable();
            $table->text('DOCUMENTO_SOPORTE')->nullable();
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
        Schema::dropIfExists('documento_actualizados');
    }
}
