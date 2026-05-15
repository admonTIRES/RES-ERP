<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarCatalogoAreainteres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_areainteres', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_AREAINTERES');
            $table->text('TIPO_AREA')->nullable();
            $table->text('NOMBRE_AREA')->nullable();
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
