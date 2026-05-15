<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_confirmacion', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_CONFRIMACION');
            $table->integer('OFERTA_ID')->nullable();
            $table->text('ACEPTACION_CONFIRMACION')->nullable();
            $table->date('FECHA_CONFIRMACION')->nullable();
            $table->text('QUIEN_ACEPTA')->nullable();
            $table->text('CARGO_ACEPTACION')->nullable();
            $table->text('DOCUMENTO_ACEPTACION')->nullable();
            $table->text('PROCEDE_ORDEN')->nullable();
            $table->text('NO_CONFIRMACION')->nullable();
            $table->date('FECHA_EMISION')->nullable();
            $table->date('FECHA_VALIDACION')->nullable();
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
        Schema::dropIfExists('');
    }
}
