<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDepartamentoAreaId2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   


     public function up()
     {
         Schema::table('departamentos_areas', function (Blueprint $table) {
             $table->text('DESCRIPCION')->nullable();
         });
     }
 
     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('departamentos_areas', function (Blueprint $table) {
             $table->dropColumn('DESCRIPCION');
         });
     }
 }
