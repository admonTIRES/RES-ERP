<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioAltadocumentoproveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_altadocumentoproveedores', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_DOCUMENTOSPROVEEDOR');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('NOMBRE_DOCUMENTO')->nullable();
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
        Schema::dropIfExists('formulario_altadocumentoproveedores');
    }
}
