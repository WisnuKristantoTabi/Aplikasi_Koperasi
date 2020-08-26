<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Member extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_table',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->char('full_name',77);
            $table->integer('users_id');
            $table->integer('jumlah_jasa_shu');
            $table->integer('jumlah_pinjaman');
            $table->integer('jumlah_simpanan_pokok');
            $table->integer('jumlah_simpanan_wajib');
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
        Schema::dropIfExists('member_table');
    }
}
