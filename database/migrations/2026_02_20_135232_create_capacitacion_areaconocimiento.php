<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacitacionAreaconocimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_areaconocimiento', function (Blueprint $table) {
            $table->increments('ID_AREA_CONOCIMIENTO');
            $table->text('NOMBRE_AREA_CONOCIMIENTO')->nullable();
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
        Schema::dropIfExists('capacitacion_areaconocimiento');
    }
}
