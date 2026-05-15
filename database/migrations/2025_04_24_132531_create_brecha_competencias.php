<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrechaCompetencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brecha_competencias', function (Blueprint $table) {
            $table->increments('ID_BRECHA_COMPETENCIAS');
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_BRECHA')->nullable();
            $table->text('PORCENTAJE_FALTANTE')->nullable();
            $table->text('BRECHA_JSON')->nullable();
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
        Schema::dropIfExists('brecha_competencias');
    }
}
