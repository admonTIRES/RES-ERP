<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioreferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_altareferenciasproveedor', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_REFERENCIASPROVEEDOR');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('NOMBRE_EMPRESA')->nullable();
            $table->text('NOMBRE_CONTACTO')->nullable();
            $table->text('CARGO_REFERENCIA')->nullable();
            $table->text('TELEFONO_REFERENCIA')->nullable();
            $table->text('CORREO_REFERENCIA')->nullable();
            $table->text('PRODUCTO_SERVICIO')->nullable();
            $table->date('DESDE_REFERENCIA')->nullable();
            $table->date('HASTA_REFERENCIA')->nullable();
            $table->text('REFERENCIA_VIGENTE')->nullable();
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
        Schema::dropIfExists('formulario_altareferenciasproveedor');
    }
}
