<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaAlmacenMantenimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_almacen_mantenimiento', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_SALIDA_MTTO');
            $table->integer('USUARIO_ID');
            $table->text('SOLICITANTE_SALIDA')->nullable();
            $table->date('FECHA_SALIDA')->nullable();
            $table->text('FIRMO_USUARIO')->nullable();
            $table->text('OBSERVACIONES_SALIDA')->nullable();
            $table->text('FIRMADO_POR')->nullable();
            $table->text('TIENE_ORDEN')->nullable();
            $table->text('NO_ORDEN_SERVICIO')->nullable();
            $table->text('NO_CUENTA_ORDEN')->nullable();
            $table->text('MATERIALES_JSON')->nullable();
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
        Schema::dropIfExists('salida_almacen_mantenimiento');
    }
}
