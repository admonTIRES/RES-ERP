<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaBuro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleccion_buro_laboral', function (Blueprint $table) {
            $table->increments('ID_BURO_SELECCION');    
            $table->text('CURP')->nullable();
            $table->text('ARCHIVO_RESULTADO')->nullable();
            $table->text('EXPERIENCIA_BURO')->nullable();
            $table->text('EXPERIENCIA_CV')->nullable();
            $table->text('LABORALES_DEMANDA')->nullable();
            $table->text('NUMERO_LABORALES')->nullable();
            $table->text('JUDICIALES_DEMANDA')->nullable();
            $table->text('NUMERO_JUDICIALES')->nullable();
            $table->text('OBSERVACIONES_BURO')->nullable();
            $table->text('PORCENTAJE_TOTAL')->nullable();
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
