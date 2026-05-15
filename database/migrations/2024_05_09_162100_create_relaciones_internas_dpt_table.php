<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacionesInternasDptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaciones_internas_dpt', function (Blueprint $table) {
            $table->increments('ID_RELACIONES_INTERNAS_DPT');
            $table->unsignedInteger('FORMULARIO_DPT_ID')->nullable();
            $table->foreign('FORMULARIO_DPT_ID')
                  ->references('ID_FORMULARIO_DPT')
                  ->on('formulario_dpt')
                  ->onDelete('cascade');         
            $table->text('INTERNAS_CONQUIEN_DPT')->nullable();
            $table->text('INTERNAS_PARAQUE_DPT')->nullable();
            $table->text('INTERNAS_FRECUENCIA_DPT')->nullable();
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
        Schema::dropIfExists('relaciones_internas_dpt');
    }

}
