<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFakturReturPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_faktur_retur_penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->char('id_faktur_retur_penjualan', 20);
            $table->integer('tb_retur_penjualan_id')->unsigned();
            $table->foreign('tb_retur_penjualan_id')->references('id_retur_penjualan')->on('tb_retur_penjualan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_faktur_retur_penjualan');
    }
}
