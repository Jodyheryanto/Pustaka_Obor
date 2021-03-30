<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKasKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_kas_keluar', function (Blueprint $table) {
            $table->increments('kode_kas_keluar');
            $table->integer('tb_terima_bukti_id')->unsigned()->nullable();
            $table->integer('tb_jurnal_pembelian_kode')->unsigned()->nullable();
            // $table->integer('tb_penjualan_buku_id')->unsigned()->nullable();
            $table->date('tgl_transaksi');
            $table->string('note', 1000);
            $table->integer('debit_pembelian')->nullable();
            $table->integer('debit_hutang')->nullable();
            $table->integer('kredit_kas_keluar');
            // $table->foreign('tb_penjualan_buku_id')->references('id_penjualan_buku')->on('tb_penjualan_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_terima_bukti_id')->references('id')->on('tb_faktur_pembelian')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_jurnal_pembelian_kode')->references('kode_jurnal_pembelian')->on('tb_jurnal_pembelian')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_kas_keluar');
    }
}
