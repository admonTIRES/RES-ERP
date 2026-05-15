<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCatalogoFuncionesgestionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalogo_funcionesgestiones', function (Blueprint $table) {
            // Eliminar el campo TIPO_FUNCION_GESTION
            $table->dropColumn('TIPO_FUNCION_GESTION');
            
            // Agregar nuevos campos
            $table->boolean('DIRECTOR_GESTION')->default(0);
            $table->boolean('LIDER_GESTION')->default(0);
            $table->boolean('COLABORADOR_GESTION')->default(0);
            $table->boolean('TODO_GESTION')->default(0);
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
