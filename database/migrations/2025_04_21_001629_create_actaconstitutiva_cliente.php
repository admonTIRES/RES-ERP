<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActaconstitutivaCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actaconstitutiva_cliente', function (Blueprint $table) {
            $table->increments('ID_ACTA_CLIENTE');
            $table->integer('CLIENTE_ID')->nullable();
            $table->text('ACTA_CONSTITUVA')->nullable();
            $table->text('NUMERO_CONSTITUVA')->nullable();
            $table->text('EVIDENCIA_CONSTITUVA')->nullable();
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
        Schema::dropIfExists('actaconstitutiva_cliente');
    }
}
