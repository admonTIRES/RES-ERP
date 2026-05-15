<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaDocumentoSoporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DOCUMENTOS_SOPORTE_CONTRATACION', function (Blueprint $table) {
            $table->increments('ID_DOCUMENTO_SOPORTE');
            $table->text('CURP')->nullable();
            $table->text('TIPO_DOCUMENTO')->nullable();
            $table->text('NOMBRE_DOCUMENTO')->nullable();
            $table->text('DOCUMENTO_SOPORTE')->nullable();
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
        //
    }
}
