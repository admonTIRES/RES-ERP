<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFormularioDesvinculacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_desvinculacion', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_DESVINCULACION');    
            $table->text('CURP')->nullable();
            $table->text('DOCUMENTO_ADEUDO')->nullable();
            $table->text('DOCUMENTO_BAJA')->nullable();
            $table->text('DOCUMENTO_CONVENIO')->nullable();
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
