<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioAltacuentaproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_altacuentaproveedor', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_CUENTAPROVEEDOR');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('TIPO_CUENTA')->nullable();
            $table->text('NOMBRE_BENEFICIARIO')->nullable();
            $table->text('NUMERO_CUENTA')->nullable();
            $table->text('TIPO_MONEDA')->nullable();
            $table->text('CLABE_INTERBANCARIA')->nullable();
            $table->text('CODIGO_SWIFT_BIC')->nullable();
            $table->text('CODIGO_ABA')->nullable();
            $table->text('DIRECCION_BANCO')->nullable();
            $table->text('CIUDAD')->nullable();
            $table->text('PAIS')->nullable();
            $table->text('CARATULA_BANCARIA')->nullable();
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
        Schema::dropIfExists('formulario_altacuentaproveedor');
    }
}
