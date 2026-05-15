<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncargadosAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encargados_areas', function (Blueprint $table) {
            $table->increments('ID_ENCARGADO_AREA');
            $table->integer('AREA_ID');
            $table->integer('TIPO_AREA_ID');
            $table->text('NOMBRE_CARGO')->nullable();
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
        Schema::dropIfExists('encargados_areas');
    }
}
