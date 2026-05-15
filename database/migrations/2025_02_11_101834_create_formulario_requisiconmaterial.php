<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioRequisiconmaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_requisiconmaterial', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_MR');
            $table->text('SOLICITANTE_MR')->nullable();
            $table->date('FECHA_SOLICITUD_MR')->nullable();
            $table->text('AREA_SOLICITANTE_MR')->nullable();
            $table->text('NO_MR')->nullable();
            $table->text('MATERIALES_JSON')->nullable();
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
        Schema::dropIfExists('formulario_requisiconmaterial');
    }
}
