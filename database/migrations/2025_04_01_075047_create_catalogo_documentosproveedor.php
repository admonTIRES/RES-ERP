<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoDocumentosproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_documentosproveedor', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_DOCUMENTOSPROVEEDOR');
            $table->text('NOMBRE_DOCUMENTO')->nullable();
            $table->text('DESCRIPCION_DOCUMENTO')->nullable();
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
        Schema::dropIfExists('catalogo_documentosproveedor');
    }
}
