<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoTituloproveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_tituloproveedores', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_TITULOPROVEEDOR');
            $table->text('NOMBRE_TITULO')->nullable();
            $table->text('ABREVIATURA_TITULO')->nullable();
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
        Schema::dropIfExists('catalogo_tituloproveedores');
    }
}
