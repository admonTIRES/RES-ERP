<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLideresCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lideres_categorias', function (Blueprint $table) {
            $table->increments('ID_LIDER_CATEGORIAS');

            $table->unsignedInteger('AREA_ID')->nullable();
            $table->foreign('AREA_ID')
                  ->references('ID_AREA')
                  ->on('areas')
            ->onDelete('cascade');

            $table->unsignedInteger('LIDER_ID')->nullable();
            $table->foreign('LIDER_ID')
                ->references('ID_CATEGORIA')
                ->on('categorias')
                ->onDelete('cascade');   


            $table->unsignedInteger('CATEGORIA_ID')->nullable();
            $table->foreign('CATEGORIA_ID')
                ->references('ID_CATEGORIA')
                ->on('categorias')
                ->onDelete('cascade');  
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
        Schema::dropIfExists('lideres_categorias');
    }
}
