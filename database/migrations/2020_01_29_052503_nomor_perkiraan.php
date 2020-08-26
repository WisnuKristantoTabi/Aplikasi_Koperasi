<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NomorPerkiraan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('detail_perkiraan_table', function (Blueprint $table) {
             $table->string('nomor_perkiraan');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('detail_perkiraan_table', function (Blueprint $table) {
             $table->string('nomor_perkiraan');
         });
     }
}
