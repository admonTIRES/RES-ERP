<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFormularioSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_solicitudes', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_SOLICITUDES');
            $table->text('NO_SOLICITUD')->nullable();
            $table->text('TIPO_SOLICITUD')->nullable();
            $table->date('FECHA_SOLICITUD')->nullable();
            $table->text('MEDIO_CONTACTO_SOLICITUD')->nullable();
            $table->text('RAZON_SOCIAL_SOLICITUD')->nullable();
            $table->text('NOMBRE_COMERCIAL_SOLICITUD')->nullable();
            $table->text('GIRO_EMPRESA_SOLICITUD')->nullable();
            $table->text('REPRESENTANTE_LEGAL_SOLICITUD')->nullable();
            $table->text('DIRECCION_SOLICITUD')->nullable();
            $table->text('CONTACTO_SOLICITUD')->nullable();
            $table->text('CARGO_SOLICITUD')->nullable();
            $table->text('TELEFONO_SOLICITUD')->nullable();
            $table->text('CELULAR_SOLICITUD')->nullable();
            $table->text('CORREO_SOLICITUD')->nullable();
            $table->text('NECESIDAD_SERVICIO_SOLICITUD')->nullable();
            $table->text('SERVICIO_SOLICITADO_SOLICITUD')->nullable();
            $table->text('TIPO_CLIENTE_SOLICITUD')->nullable();
            $table->text('OBSERVACIONES_SOLICITUD')->nullable();
            $table->text('ESTATUS_SOLICITUD')->nullable();
            $table->text('FECHA_NOTIFICACION_SOLICITUD')->nullable();
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
        Schema::dropIfExists('formulario_solicitudes');
    }
}
