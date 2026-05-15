<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCursosPpt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos_ppt', function (Blueprint $table) {
            $table->increments('ID_CURSOS_PPT');
            $table->integer('FORMULARO_PPT_ID');
            $table->text('CURSO_PPT')->nullable();
            $table->text('CURSO_REQUERIDO')->nullable();
            $table->text('CURSO_DESEABLE')->nullable();
            $table->text('CURSO_CUMPLE_PPT')->nullable();
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
        Schema::dropIfExists('cursos_ppt');
    }
}
