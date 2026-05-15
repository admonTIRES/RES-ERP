<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_clientes', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_CLIENTES');
            $table->text('RFC_CLIENTE')->nullable();
            $table->text('RAZON_SOCIAL_CLIENTE')->nullable();
            $table->text('NOMBRE_COMERCIAL_CLIENTE')->nullable();
            $table->text('GIRO_EMPRESA_CLIENTE')->nullable();
            $table->text('REPRESENTANTE_LEGAL_CLIENTE')->nullable();
            $table->text('PAGINA_CLIENTE')->nullable();
            $table->text('CONTACTOS_JSON')->nullable();
            $table->text('DIRECCIONES_JSON')->nullable();
            $table->text('EMITE_ORDEN')->nullable();
            $table->text('CONSTANCIA_DOCUMENTO')->nullable();
            $table->date('FECHA_CONSTANCIA')->nullable();
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
        Schema::dropIfExists('formulario_clientes');
    }
}
