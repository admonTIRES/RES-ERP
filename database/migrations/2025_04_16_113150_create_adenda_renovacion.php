<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdendaRenovacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adenda_renovacion', function (Blueprint $table) {
            $table->increments('ID_ADENDA_RENOVACION');
            $table->integer('RENOVACION_ID')->nullable();
            $table->date('FECHAI_ADENDA')->nullable();
            $table->date('FECHAF_ADENDA')->nullable();
            $table->text('COMENTARIO_ADENDA')->nullable();
            $table->text('DOCUMENTO_ADENDA')->nullable();
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
        Schema::dropIfExists('adenda_renovacion');
    }
}
