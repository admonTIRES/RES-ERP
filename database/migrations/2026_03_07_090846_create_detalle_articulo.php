<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_articulo', function (Blueprint $table) {
            $table->increments('ID_DETALLE_ARTICULO');
            $table->integer('INVENTARIO_ID')->nullable();
            $table->text('NOMBRE_COMPONENTE')->nullable();
            $table->text('CODIGO_PARTE')->nullable();
            $table->text('CANTIDAD_DETALLE')->nullable();
            $table->date('FECHA_COMPRA')->nullable();
            $table->text('REQUIERE_REEMPLAZO')->nullable();
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
        Schema::dropIfExists('detalle_articulo');
    }
}
