<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioAltacertificacionproveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_altacertificacionproveedor', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_CERTIFICACIONPROVEEDOR');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('TIPO_DOCUMENTO')->nullable();
            $table->text('NORMA_CERTIFICACION')->nullable();
            $table->text('VERSION_CERTIFICACION')->nullable();
            $table->text('ENTIDAD_CERTIFICADORA')->nullable();
            $table->date('DESDE_CERTIFICACION')->nullable();
            $table->date('HASTA_CERTIFICACION')->nullable();
            $table->text('DOCUMENTO_CERTIFICACION')->nullable();
            $table->text('NORMA_ACREDITACION')->nullable();
            $table->text('VERSION_ACREDITACION')->nullable();
            $table->text('ALCANCE_ACREDITACION')->nullable();
            $table->text('ENTIDAD_ACREDITADORA')->nullable();
            $table->date('DESDE_ACREDITACION')->nullable();
            $table->text('DOCUMENTO_ACREDITACION')->nullable();
            $table->text('REQUISITO_AUTORIZACION')->nullable();
            $table->text('ENTIDAD_AUTORIZADORA')->nullable();
            $table->date('DESDE_AUTORIZACION')->nullable();
            $table->date('HASTA_ACREDITACION')->nullable();
            $table->text('DOCUMENTO_AUTORIZACION')->nullable();
            $table->text('NOMBRE_ENTIDAD_MEMBRESIA')->nullable();
            $table->date('DESDE_MEMBRESIA')->nullable();
            $table->date('HASTA_MEMBRESIA')->nullable();
            $table->text('DOCUMENTO_MEMBRESIA')->nullable();
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
        Schema::dropIfExists('formulario_altacertificacionproveedor');
    }
}
