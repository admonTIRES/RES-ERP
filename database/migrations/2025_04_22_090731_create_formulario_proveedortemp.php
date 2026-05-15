<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioProveedortemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_proveedortemp', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_PRO');
            $table->text('RFC_PROVEEDORTEMP')->nullable();
            $table->text('NOMBRE_PROVEEDORTEMP')->nullable();
            $table->text('RAZON_PROVEEDORTEMP')->nullable();
            $table->text('GIRO_PROVEEDORTEMP')->nullable();

            
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
        Schema::dropIfExists('formulario_proveedortemp');
    }
}
