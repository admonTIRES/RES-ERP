<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacionpagosproveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacionpagosproveedores', function (Blueprint $table) {
            $table->increments('ID_RELACION_PAGOS');
            $table->text('JSON_RELACIONES')->nullable();
            $table->date('FECHA_RELACION')->nullable();
            $table->text('MONTO_MXN')->nullable();
            $table->text('MONTO_USD')->nullable();
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
        Schema::dropIfExists('relacionpagosproveedores');
    }
}
