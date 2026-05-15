<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id('ID_AREA');
            $table->text('NOMBRE');
            $table->text('DESCRIPCION');
            $table->integer('TIPO_AREA_ID'); // AQUI INDICAMOS SI ES UNA AREA DE DIRECCION, UNA AREA QUE DEPENDE DE OTRA ETC.
            $table->integer('USUARIO_ID'); //ESTE SERA EL JEFE DEL AREA
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
        Schema::dropIfExists('areas');
    }
}
