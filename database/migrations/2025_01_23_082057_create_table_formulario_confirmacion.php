<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFormularioConfirmacion extends Migration
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
            $table->text('NO_OFERTA')->nullable();
            $table->text('NO_CONFIRMACION')->nullable();
            $table->text('ACEPTACION_CONFIRMACION')->nullable();
            $table->date('FECHA_CONFIRMACION')->nullable();
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
        Schema::dropIfExists('table_formulario_confirmacion');
    }
}
