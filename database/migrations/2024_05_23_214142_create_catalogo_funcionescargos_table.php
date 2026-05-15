<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoFuncionescargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_funcionescargos', function (Blueprint $table) {
            $table->increments('ID_CATALOGO_FUNCIONESCARGO');
            $table->text('TIPO_FUNCION_CARGO')->nullable();
            $table->text('CATEGORIAS_CARGO')->nullable();
            $table->text('DESCRIPCION_FUNCION_CARGO')->nullable();
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
        Schema::dropIfExists('catalogo_funcionescargos');
    }
}
