<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbJurnalPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jurnal_pembelian', function (Blueprint $table) {
            $table->increments('kode_jurnal_pembelian');
            $table->integer('tb_terima_bukti_id')->unsigned();
            $table->date('tgl_transaksi');
            $table->string('supplier', 255);
            $table->string('note', 1000);
            $table->string('syarat_pembayaran', 1000);
            $table->integer('debit_pembelian');
            $table->integer('kredit_hutang');
            $table->foreign('tb_terima_bukti_id')->references('id')->on('tb_faktur_pembelian')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_jurnal_pembelian');
    }
}
