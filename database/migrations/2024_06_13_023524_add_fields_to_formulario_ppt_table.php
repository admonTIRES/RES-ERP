<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFormularioPptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulario_ppt', function (Blueprint $table) {
            $table->text('PUESTO1_NOMBRE')->nullable();
            $table->text('PUESTO1')->nullable();
            $table->text('PUESTO1_CUMPLE_PPT')->nullable();
            $table->text('PUESTO2_NOMBRE')->nullable();
            $table->text('PUESTO2')->nullable();
            $table->text('PUESTO2_CUMPLE_PPT')->nullable();
            $table->text('PUESTO3_NOMBRE')->nullable();
            $table->text('PUESTO3')->nullable();
            $table->text('PUESTO3_CUMPLE_PPT')->nullable();
            $table->text('PUESTO4_NOMBRE')->nullable();
            $table->text('PUESTO4')->nullable();
            $table->text('PUESTO4_CUMPLE_PPT')->nullable();
            $table->text('PUESTO5_NOMBRE')->nullable();
            $table->text('PUESTO5')->nullable();
            $table->text('PUESTO5_CUMPLE_PPT')->nullable();
            $table->text('PUESTO6_NOMBRE')->nullable();
            $table->text('PUESTO6')->nullable();
            $table->text('PUESTO6_CUMPLE_PPT')->nullable();
            $table->text('PUESTO7_NOMBRE')->nullable();
            $table->text('PUESTO7')->nullable();
            $table->text('PUESTO7_CUMPLE_PPT')->nullable();
            $table->text('PUESTO8_NOMBRE')->nullable();
            $table->text('PUESTO8')->nullable();
            $table->text('PUESTO8_CUMPLE_PPT')->nullable();
            $table->text('PUESTO9_NOMBRE')->nullable();
            $table->text('PUESTO9')->nullable();
            $table->text('PUESTO9_CUMPLE_PPT')->nullable();
            $table->text('PUESTO10_NOMBRE')->nullable();
            $table->text('PUESTO10')->nullable();
            $table->text('PUESTO10_CUMPLE_PPT')->nullable();
            
            

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulario_ppt', function (Blueprint $table) {
            //
        });
    }
}
