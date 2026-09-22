<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesPagoAgrupados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_pago_agrupados', function (Blueprint $table) {
            $table->increments('ID_COMPROBANTE_AGRUPADO');
            $table->text('RFC_PROVEEDOR')->nullable();
            $table->text('IDS_FACTURAS')->nullable();
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
        Schema::dropIfExists('comprobantes_pago_agrupados');
    }
}
