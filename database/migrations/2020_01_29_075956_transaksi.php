<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_table',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('member_table_id');
            $table->string('jenis_transaksi');
            $table->integer('detail_perkiraan_table_id');
            $table->string('keterangan');
            $table->string('id_periode');
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
        Schema::dropIfExists('transaksi_table');
    }
}
