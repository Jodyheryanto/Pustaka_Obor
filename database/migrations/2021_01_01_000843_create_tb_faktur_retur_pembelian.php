<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFakturReturPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_faktur_retur_pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->char('id_faktur_retur_pembelian', 20);
            $table->integer('tb_retur_pembelian_id')->unsigned();
            $table->foreign('tb_retur_pembelian_id')->references('id_retur_pembelian')->on('tb_retur_pembelian')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_faktur_retur_pembelian');
    }
}
