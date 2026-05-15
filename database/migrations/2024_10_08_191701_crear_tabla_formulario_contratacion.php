<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFormularioContratacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_contratacion', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_CONTRATACION');    
            $table->text('CURP')->nullable();
            $table->text('NOMBRE_COLABORADOR')->nullable();
            $table->text('PRIMER_APELLIDO')->nullable();
            $table->text('SEGUNDO_APELLIDO')->nullable();
            $table->text('INICIALES_COLABORADOR')->nullable();
            $table->text('DIA_COLABORADOR')->nullable();
            $table->text('MES_COLABORADOR')->nullable();
            $table->text('ANIO_COLABORADOR')->nullable();
            $table->text('EDAD_COLABORADOR')->nullable();
            
            $table->text('FOTO_USUARIO')->nullable();
            $table->text('LUGAR_NACIMIENTO')->nullable();
            $table->text('TELEFONO_COLABORADOR')->nullable();
            $table->text('CORREO_COLABORADOR')->nullable();
            $table->text('ESTADO_CIVIL')->nullable();
            $table->text('RFC_COLABORADOR')->nullable();
            $table->date('VIGENCIA_INE')->nullable();
            $table->text('NSS_COLABORADOR')->nullable();
            $table->text('TIPO_SANGRE')->nullable();
            $table->text('ALERGIAS_COLABORADOR')->nullable();
            $table->text('CALLE_COLABORADOR')->nullable();
            $table->text('COLONIA_COLABORADOR')->nullable();
            $table->text('CODIGO_POSTAL')->nullable();
            $table->text('CIUDAD_COLABORADOR')->nullable();
            $table->text('ESTADO_COLABORADOR')->nullable();
            $table->text('NOMBRE_EMERGENCIA')->nullable();
            $table->text('PARENTESCO_EMERGENCIA')->nullable();
            $table->text('TELEFONO1_EMERGENCIA')->nullable();
            $table->text('TELEFONO2_EMERGENCIA')->nullable();
            $table->text('NOMBRE_BENEFICIARIO')->nullable();
            $table->text('PARENTESCO_BENEFICIARIO')->nullable();
            $table->text('PORCENTAJE_BENEFICIARIO')->nullable();
            $table->text('TELEFONO1_BENEFICIARIO')->nullable();
            $table->text('TELEFONO2_BENEFICIARIO')->nullable();
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
        //
    }
}
