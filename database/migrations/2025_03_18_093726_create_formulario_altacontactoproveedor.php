<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioAltacontactoproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_altacontactoproveedor', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_CUENTAPROVEEDOR');
            $table->text('NOMBRE_CONTACTO')->nullable();
            $table->text('TITULO_CONTACTO')->nullable();
            $table->text('FUNCIONES_CONTACTOS')->nullable();

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
        Schema::dropIfExists('formulario_altacontactoproveedor');
    }
}
