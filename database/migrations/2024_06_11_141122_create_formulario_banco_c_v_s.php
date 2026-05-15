<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioBancoCVS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_bancocv', function (Blueprint $table) {
            $table->increments('ID_BANCO_CV');
            $table->text('AVISO_PRIVACIDAD')->nullable();
            $table->text('NOMBRE_CV')->nullable();
            $table->text('PRIMER_APELLIDO_CV')->nullable();
            $table->text('SEGUNDO_APELLIDO_CV')->nullable();
            $table->text('CORREO_CV')->nullable();
            $table->text('NUMERO1_CV')->nullable();
            $table->text('TIPO_TELEFONO1')->nullable();
            $table->text('TELEFONO_CELULAR2_CV')->nullable();
            $table->text('CURP_CV');
            $table->text('DIA_FECHA_CV')->nullable();
            $table->text('MES_FECHA_CV')->nullable();
            $table->text('ANO_FECHA_CV')->nullable();
            $table->text('ULTIMO_GRADO_CV')->nullable();
            $table->text('NOMBRE_LICENCIATURA_CV')->nullable();
            $table->text('TIPO_POSGRADO_CV')->nullable();
            $table->text('NOMBRE_POSGRADO_CV')->nullable();
            $table->text('ARCHIVO_CURP_CV')->nullable();
            $table->text('ARCHIVO_CV')->nullable();
            $table->text('CUENTA_TITULO_CV')->nullable();
            $table->text('OBSERVACIO_CV')->nullable();
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
        Schema::dropIfExists('formulario_bancocv');
    }
}
