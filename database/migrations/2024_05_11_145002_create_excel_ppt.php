<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcelPpt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_ppt', function (Blueprint $table) {

            $table->increments('ID_DOCUMENTO_PPT');
            $table->integer('USUARIO_ID')->nullable();
            $table->unsignedInteger('DEPARTAMENTO_AREA_ID')->nullable();
            $table->foreign('DEPARTAMENTO_AREA_ID')
                ->references('ID_DEPARTAMENTO_AREA')
                ->on('departamentos_areas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('FORMULARIO_PPT_ID')->nullable();
            $table->foreign('FORMULARIO_PPT_ID')
            ->references('ID_FORMULARIO_PPT')
            ->on('formulario_ppt')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->text('RUTA_PPT');
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
        Schema::dropIfExists('excel_ppt');
    }
}
