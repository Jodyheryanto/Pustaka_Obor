<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbJurnalUmum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jurnal_umum', function (Blueprint $table) {
            $table->increments('kode_jurnal_umum');
            $table->integer('tb_retur_penjualan_id')->unsigned()->nullable();
            $table->integer('tb_retur_pembelian_id')->unsigned()->nullable();
            $table->integer('tb_penjualan_buku_id')->unsigned()->nullable();
            $table->integer('tb_pembelian_buku_id')->unsigned()->nullable();
            $table->date('tgl_transaksi_retur');
            $table->integer('kredit_piutang')->nullable();
            $table->integer('debit_retur_penjualan')->nullable();
            $table->integer('kredit_retur_pembelian')->nullable();
            $table->integer('debit_hutang')->nullable();
            $table->integer('debit_kredit_royalti')->nullable();
            $table->integer('debit_kredit_denda')->nullable();
            $table->foreign('tb_penjualan_buku_id')->references('id_penjualan_buku')->on('tb_penjualan_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_pembelian_buku_id')->references('id_pembelian_buku')->on('tb_pembelian_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_retur_pembelian_id')->references('id_retur_pembelian')->on('tb_retur_pembelian')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_jurnal_umum');
    }
}
