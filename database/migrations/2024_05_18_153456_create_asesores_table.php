<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('catalogo_asesores', function (Blueprint $table) {
                $table->increments('ID_CATALOGO_ASESOR');
                $table->text('NOMBRE_ASESOR')->nullable();
                $table->text('DESCRIPCION_ASESOR')->nullable();
                $table->text('ASESOR_ES')->nullable();
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
        Schema::dropIfExists('asesores');
    }
}
