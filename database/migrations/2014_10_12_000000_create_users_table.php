<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('ID_USUARIO');
            $table->string('NOMBRE');
            $table->string('APELLIDO_PATERNO');
            $table->string('APELLIDO_MATERNO');
            $table->string('DIRECCION');
            $table->string('TELEFONO');
            $table->string('FECHA_NACIMIENTO');
            $table->string('FOTO');
            $table->string('CORREO')->unique();
            $table->string('PASSWORD');
            $table->integer('TIPO_USUARIO_ID');
            $table->integer('CARGO_USUARIO_ID'); 
            $table->boolean('ACTIVO')->default(1);
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
        Schema::dropIfExists('users');
    }
}
