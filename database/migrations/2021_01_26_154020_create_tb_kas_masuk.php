<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKasMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_kas_masuk', function (Blueprint $table) {
            $table->increments('kode_kas_masuk');
            $table->integer('tb_faktur_penjualan_id')->unsigned()->nullable();
            $table->integer('tb_jurnal_penjualan_kode')->unsigned()->nullable();
            // $table->integer('tb_retur_penjualan_id')->unsigned()->nullable();
            $table->date('tgl_transaksi');
            $table->string('note', 1000);
            $table->integer('debit_kas_masuk');
            $table->integer('kredit_penjualan')->nullable();
            $table->integer('kredit_piutang')->nullable();
            // $table->foreign('tb_retur_penjualan_id')->references('id_retur_penjualan')->on('tb_retur_penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_faktur_penjualan_id')->references('id')->on('tb_faktur_penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_jurnal_penjualan_kode')->references('kode_jurnal_penjualan')->on('tb_jurnal_penjualan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_kas_masuk');
    }
}
