<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FormularioDirectorio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_directorio', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_DIRECTORIO');
            $table->text('RAZON_SOCIAL')->nullable();
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('NOMBRE_COMERCIAL')->nullable();
            $table->text('GIRO_PROVEEDOR')->nullable();
            $table->text('CODIGO_POSTAL')->nullable();
            $table->text('TIPO_VIALIDAD_EMPRESA')->nullable();
            $table->text('NOMBRE_VIALIDAD_EMPRESA')->nullable();
            $table->text('NUMERO_EXTERIOR_EMPRESA')->nullable();
            $table->text('NUMERO_INTERIOR_EMPRESA')->nullable();
            $table->text('NOMBRE_COLONIA_EMPRESA')->nullable();
            $table->text('NOMBRE_LOCALIDAD_EMPRESA')->nullable();
            $table->text('NOMBRE_MUNICIPIO_EMPRESA')->nullable();
            $table->text('NOMBRE_ENTIDAD_EMPRESA')->nullable();
            $table->text('PAIS_EMPRESA')->nullable();
            $table->text('ENTRE_CALLE_EMPRESA')->nullable();
            $table->text('ENTRE_CALLE2_EMPRESA')->nullable();
            $table->text('NOMBRE_DIRECTORIO')->nullable();
            $table->text('CARGO_DIRECTORIO')->nullable();
            $table->text('TELEFONO_DIRECOTORIO')->nullable();
            $table->text('EXSTENSION_DIRECTORIO')->nullable();
            $table->text('CELULAR_DIRECTORIO')->nullable();
            $table->text('SERVICIOS_JSON')->nullable();
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
        //
    }
}
