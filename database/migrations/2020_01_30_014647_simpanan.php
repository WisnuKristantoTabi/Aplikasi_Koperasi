<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Simpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_table',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('member_table_id');
            $table->integer('simpanan_pokok');
            $table->integer('simpanan_wajib');
            $table->integer('simpanan_sukarela');
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
        Schema::dropIfExists('simpanan_table');
    }
}
