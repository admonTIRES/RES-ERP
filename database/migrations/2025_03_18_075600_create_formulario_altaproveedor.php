<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioAltaproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_altaproveedor', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_ALTA');


            $table->text('TIPO_PERSONA_ALTA')->nullable();
            $table->text('RAZON_SOCIAL_ALTA')->nullable();
            $table->text('REPRESENTANTE_LEGAL_ALTA')->nullable();
            $table->text('RFC_ALTA')->nullable();
            $table->text('REGIMEN_ALTA')->nullable();
            $table->text('CODIGO_POSTAL')->nullable();
            $table->text('TIPO_VIALIDAD_EMPRESA')->nullable();
            $table->text('NOMBRE_VIALIDAD_EMPRESA')->nullable();
            $table->text('NUMERO_EXTERIOR_EMPRESA')->nullable();
            $table->text('NUMERO_INTERIOR_EMPRESA')->nullable();
            $table->text('NOMBRE_COLONIA_EMPRESA')->nullable();
            $table->text('NOMBRE_LOCALIDAD_EMPRESA')->nullable();
            $table->text('NOMBRE_MUNICIPIO_EMPRESA')->nullable();
            $table->text('NOMBRE_ENTIDAD_EMPRESA')->nullable();
            $table->text('PAIS_EMPRESA')->nullable();
            $table->text('ENTRE_CALLE_EMPRESA')->nullable();
            $table->text('ENTRE_CALLE2_EMPRESA')->nullable();
            $table->text('DOMICILIO_EXTRANJERO')->nullable();
            $table->text('CODIGO_EXTRANJERO')->nullable();
            $table->text('CIUDAD_EXTRANJERO')->nullable();
            $table->text('ESTADO_EXTRANJERO')->nullable();
            $table->text('PAIS_EXTRANJERO')->nullable();
            $table->text('CORRE_TITULAR_ALTA')->nullable();
            $table->text('TELEFONO_OFICINA_ALTA')->nullable();
            $table->text('PAGINA_WEB_ALTA')->nullable();
            $table->text('ACTIVIDAD_ECONOMICA')->nullable();
            $table->text('CUAL_ACTVIDAD_ECONOMICA')->nullable();
            $table->text('ACTVIDAD_COMERCIAL')->nullable();
            $table->text('DESCUENTOS_ACTIVIDAD_ECONOMICA')->nullable();
            $table->text('CUAL_DESCUENTOS_ECONOMICA')->nullable();
            $table->text('DIAS_CREDITO_ALTA')->nullable();
            $table->text('TERMINOS_IMPORTANCIAS_ALTA')->nullable();
            $table->text('VINCULO_FAMILIAR')->nullable();
            $table->text('DESCRIPCION_VINCULO')->nullable();
            $table->text('SERVICIOS_PEMEX')->nullable();
            $table->text('BENEFICIOS_PERSONA')->nullable();
            $table->text('BENEFICIOS_PERSONA')->nullable();
            
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
        Schema::dropIfExists('formulario_altaproveedor');
    }
}
