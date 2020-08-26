<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailPerkiraan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_perkiraan_table',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('perkiraan_table_id');
            $table->string('nama_perkiraan');
            $table->integer('jumlah_perkiraan');
            $table->string('periode');
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
        Schema::dropIfExists('detail_perkiraan_table');
    }
}
