<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioRespaldoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_respaldo', function (Blueprint $table) {
            $table->increments('ID_RESPALDO_INVENTARIO'); 
            $table->integer('INVENTARIO_ID'); 
            $table->text('FOTO_EQUIPO')->nullable();
            $table->text('DESCRIPCION_EQUIPO')->nullable();
            $table->text('MARCA_EQUIPO')->nullable();
            $table->text('MODELO_EQUIPO')->nullable();
            $table->text('SERIE_EQUIPO')->nullable();
            $table->text('CODIGO_EQUIPO')->nullable();
            $table->text('CANTIDAD_EQUIPO')->nullable();
            $table->text('UBICACION_EQUIPO')->nullable();
            $table->text('ESTADO_EQUIPO')->nullable();
            $table->date('FECHA_ADQUISICION')->nullable();
            $table->text('PROVEEDOR_EQUIPO')->nullable();
            $table->text('UNITARIO_EQUIPO')->nullable();
            $table->text('TOTAL_EQUIPO')->nullable();
            $table->text('TIPO_EQUIPO')->nullable();
            $table->boolean('ACTIVO')->default(1);
            $table->text('OBSERVACION_EQUIPO')->nullable();
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
        Schema::dropIfExists('inventario_respaldo');
    }
}
