<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbJurnalPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jurnal_penjualan', function (Blueprint $table) {
            $table->increments('kode_jurnal_penjualan');
            $table->integer('tb_faktur_penjualan_id')->unsigned();
            $table->date('tgl_transaksi');
            $table->string('pelanggan', 255);
            $table->string('syarat_pembayaran', 1000);
            $table->integer('debit_piutang');
            $table->integer('kredit_penjualan');
            $table->foreign('tb_faktur_penjualan_id')->references('id')->on('tb_faktur_penjualan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_jurnal_penjualan');
    }
}
