<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioMttoinstalaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_mttoinstalaciones', function (Blueprint $table) {
            $table->increments('ID_f_MTTO');
            $table->text('FOTO_INSTALACION')->nullable();
            $table->text('DESCRIPCION_INSTALACION')->nullable();
            $table->text('UBICACION_INSTALACION')->nullable();
            $table->text('ESPECIFICACIONES_INSTALACION')->nullable();
            $table->text('ANIO_CONSTRUCCION_INSTALACION')->nullable();
            $table->text('PROVEEDOR_ALTA')->nullable();
            $table->text('PROVEEDOR_INSTALACION')->nullable();
            $table->text('NOMBRE_PROVEEDOR_INSTALACION')->nullable();
            $table->text('MANTENIMIENTO_INSTALACION')->nullable();
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
        Schema::dropIfExists('formulario_mttoinstalaciones');
    }
}
