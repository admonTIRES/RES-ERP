<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoCorreosEnviadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_correos_enviados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_id');
            $table->timestamp('fecha_envio')->useCurrent();
            $table->unique('po_id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_correos_enviados');
    }
}
