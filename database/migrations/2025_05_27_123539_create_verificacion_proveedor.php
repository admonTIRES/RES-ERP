<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificacionProveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificacion_proveedor', function (Blueprint $table) {
            $table->increments('ID_VERIFICACION_PROVEEDOR');
            $table->integer('PROVEEDOR_ID')->nullable();
            $table->text('REQUIERE_FECHA')->nullable();
            $table->text('REQUIERE_FECHA')->nullable();

            $table->text('EVIDENCIA_VERIFICACION')->nullable();
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
        Schema::dropIfExists('verificacion_proveedor');
    }
}
