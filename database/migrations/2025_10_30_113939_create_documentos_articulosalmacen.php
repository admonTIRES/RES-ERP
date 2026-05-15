<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosArticulosalmacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_articulosalmacen', function (Blueprint $table) {
            $table->increments('ID_DOCUMENTO_ARTICULO');
            $table->integer('INVENTARIO_ID')->nullable();
            $table->text('NOMBRE_DOCUMENTO')->nullable();
            $table->text('REQUIERE_FECHA')->nullable();
            $table->text('INDETERMINADO_DOCUMENTO')->nullable();
            $table->date('FECHAI_DOCUMENTO')->nullable();
            $table->date('FECHAF_DOCUMENTO')->nullable();
            $table->text('DOCUMENTO_ARTICULO')->nullable();
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
        Schema::dropIfExists('documentos_articulosalmacen');
    }
}
