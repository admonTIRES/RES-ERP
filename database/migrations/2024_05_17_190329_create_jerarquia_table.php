<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJerarquiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_jerarquia', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_JERARQUIA');
            $table->text('NOMBRE_JERARQUIA')->nullable();
            $table->text('DESCRIPCION_JERARQUIA')->nullable();
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
        Schema::dropIfExists('jerarquia');
    }
}
