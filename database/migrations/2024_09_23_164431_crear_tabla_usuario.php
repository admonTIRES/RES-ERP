<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('ID_USUARIO'); // Campo de ID autoincremental
            $table->text('USUARIO_TIPO')->nullable();
            $table->text('EMPLEADO_NOMBRE')->nullable();
            $table->text('EMPLEADO_APELLIDOPATERNO')->nullable();
            $table->text('EMPLEADO_APELLIDOMATERNO')->nullable();
            $table->text('FOTO_USUARIO')->nullable();
            $table->text('EMPLEADO_DIRECCION')->nullable();
            $table->text('EMPLEADO_CARGO')->nullable();
            $table->text('EMPLEADO_TELEFONO')->nullable();
            $table->date('EMPLEADO_FECHANACIMIENTO')->nullable();
            $table->text('EMPLEADO_CORREO')->nullable(); 
            $table->text('PASSWORD')->nullable(); 
            $table->text('PASSWORD_2')->nullable();
            $table->rememberToken(); 
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
        //
    }
}
