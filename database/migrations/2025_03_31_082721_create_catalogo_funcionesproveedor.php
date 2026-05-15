<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoFuncionesproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_funcionesproveedor', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_FUNCIONESPROVEEDOR');
            $table->text('NOMBRE_FUNCIONES')->nullable();
            $table->text('DESCRIPCION_FUNCIONES')->nullable();
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
        Schema::dropIfExists('catalogo_funcionesproveedor');
    }
}
