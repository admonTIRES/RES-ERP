<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos_proveedores', function (Blueprint $table) {
            $table->increments('ID_CONTRATO_PROVEEDORES');
            $table->date('FECHAI_CONTRATO_PROVEEDOR')->nullable();
            $table->date('FECHAF_CONTRATO_PROVEEDOR')->nullable();
            $table->text('DOCUMENTO_CONTRATO_PROVEEDOR')->nullable();
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
        Schema::dropIfExists('contratos_proveedores');
    }
}
