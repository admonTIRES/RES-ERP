<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioFacturasproveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_facturasproveedores', function (Blueprint $table) {
            $table->increments('ID_FORMULARIO_FACTURACION');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('TIPO_FACTURA')->nullable();
            $table->text('NO_PO')->nullable();
            $table->text('NO_GR')->nullable();
            $table->text('DOCUMENTOS_SOPORTE_FACTURA')->nullable();
            $table->text('FACTURA_PDF')->nullable();
            $table->text('FACTURA_XML')->nullable();
            $table->text('FOLIO_FISCAL')->nullable();
            $table->date('FECHA_FACTURA')->nullable();
            $table->text('METODO_PAGO')->nullable();
            $table->text('MONEDA_FACTURA')->nullable();
            $table->text('SUBTOTAL_FACTURA')->nullable();
            $table->text('IVA_FACTURA')->nullable();
            $table->text('TOTAL_FACTURA')->nullable();
            $table->text('NO_FACTURA_EXTRANJERO')->nullable();
            $table->date('FECHA_FACTURA_EXTRANJERO')->nullable();
            $table->text('MONEDA_FACTURA_EXTRANJERO')->nullable();
            $table->text('SUBTOTAL_FACTURA_EXTRANJERO')->nullable();
            $table->text('IVA_FACTURA_EXTRANJERO')->nullable();
            $table->text('TOTAL_FACTURA_EXTRANJERO')->nullable();
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
        Schema::dropIfExists('formulario_facturasproveedores');
    }
}
