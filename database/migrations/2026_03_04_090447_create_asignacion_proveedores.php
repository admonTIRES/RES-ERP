<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignacion_proveedores', function (Blueprint $table) {
            $table->increments('ID_ASINGACIONES_PROVEEDORES');
            $table->text('ASIGNACIONES_ID')->nullable();
            $table->text('TIPO_ASIGNACION')->nullable();
            $table->text('PERSONAL_ASIGNA')->nullable();
            $table->date('FECHA_ASIGNACION')->nullable();
            $table->text('ALMACENISTA_ASIGNACION')->nullable();
            $table->text('DOCUMENTO_ASIGNACION')->nullable();
            $table->text('RFC')->nullable();
            $table->text('EPP_JSON')->nullable();
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
        Schema::dropIfExists('asignacion_proveedores');
    }
}
