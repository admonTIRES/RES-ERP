<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepartamentosAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos_areas', function (Blueprint $table) {
            $table->id('DEPARTAMENTO_AREA_ID');
            $table->text('NOMBRE');
            $table->text('DESCRIPCION');
            $table->integer('USUARIO_ID'); // ESTE ES UNA FK PARA VER QUIEN ES EL ENCARGADO DEL AREA
            $table->integer('AREA_ID'); // ESTE ES UNA FK PARA VER QUE AREA ESTA ENCARGADA DEL DEPARTAMENTO
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
        Schema::dropIfExists('departamentos_areas');
    }
}
