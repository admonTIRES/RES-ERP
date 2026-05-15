<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHojaTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_trabajo', function (Blueprint $table) {
            $table->id();

            $table->string('NO_MR');

            // Datos del material
            $table->text('DESCRIPCION');
            $table->string('CANTIDAD')->nullable();
            $table->string('UNIDAD_MEDIDA')->nullable();

            // Cotización Q1
            $table->string('PROVEEDOR_Q1')->nullable();
            $table->decimal('SUBTOTAL_Q1', 12, 2)->nullable();
            $table->decimal('IVA_Q1', 12, 2)->nullable();
            $table->decimal('IMPORTE_Q1', 12, 2)->nullable();
            $table->text('OBSERVACIONES_Q1')->nullable();
            $table->date('FECHA_COTIZACION_Q1')->nullable();
            $table->string('DOCUMENTO_Q1')->nullable(); // nombre o ruta del archivo

            // Cotización Q2
            $table->string('PROVEEDOR_Q2')->nullable();
            $table->decimal('SUBTOTAL_Q2', 12, 2)->nullable();
            $table->decimal('IVA_Q2', 12, 2)->nullable();
            $table->decimal('IMPORTE_Q2', 12, 2)->nullable();
            $table->text('OBSERVACIONES_Q2')->nullable();
            $table->date('FECHA_COTIZACION_Q2')->nullable();
            $table->string('DOCUMENTO_Q2')->nullable();

            // Cotización Q3
            $table->string('PROVEEDOR_Q3')->nullable();
            $table->decimal('SUBTOTAL_Q3', 12, 2)->nullable();
            $table->decimal('IVA_Q3', 12, 2)->nullable();
            $table->decimal('IMPORTE_Q3', 12, 2)->nullable();
            $table->text('OBSERVACIONES_Q3')->nullable();
            $table->date('FECHA_COTIZACION_Q3')->nullable();
            $table->string('DOCUMENTO_Q3')->nullable();

            // Datos adicionales
            $table->string('PROVEEDOR_SUGERIDO')->nullable();
            $table->string('FORMA_ADQUISICION')->nullable();
            $table->string('PROVEEDOR_SELECCIONADO')->nullable();
            $table->decimal('MONTO_FINAL', 12, 2)->nullable();
            $table->string('FORMA_PAGO')->nullable();
            $table->string('REQUIERE_PO')->nullable();

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
        Schema::dropIfExists('hoja_trabajo');
    }
}
