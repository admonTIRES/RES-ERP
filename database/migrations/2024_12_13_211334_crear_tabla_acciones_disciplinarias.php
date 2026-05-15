<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAccionesDisciplinarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acciones_disciplinarias_contrato', function (Blueprint $table) {
            $table->increments('ID_ACCIONES_DISCIPLINARIAS');
            $table->integer('CONTRATO_ID')->nullable();
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_DOCUMENTO_ACCIONES')->nullable();
            $table->text('DOCUMENTO_ACCIONES_DISCIPLINARIAS')->nullable();
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
        //
    }
}
