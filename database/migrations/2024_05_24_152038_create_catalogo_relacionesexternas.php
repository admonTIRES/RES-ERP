<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoRelacionesexternas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_relacionesexternas', function (Blueprint $table) {
                $table->increments('ID_CATALOGO_RELACIONESEXTERNAS');
                $table->text('NOMBRE_RELACIONEXTERNA')->nullable();
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
        Schema::dropIfExists('catalogo_relacionesexternas');
    }
}
