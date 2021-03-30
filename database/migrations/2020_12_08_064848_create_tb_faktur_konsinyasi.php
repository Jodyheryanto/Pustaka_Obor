<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFakturKonsinyasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_faktur_konsinyasi', function (Blueprint $table) {
            $table->increments('id');
            $table->char('id_faktur_konsinyasi', 20);
            $table->char('tb_induk_buku_kode_buku', 20);
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('discount');
            $table->integer('harga_total');
            $table->integer('tb_pelanggan_id')->unsigned()->nullable();
            $table->integer('tb_supplier_id')->unsigned()->nullable();
            $table->date('tgl_titip');
            $table->tinyInteger('status_titip');
            $table->tinyInteger('status_terjual');
            $table->foreign('tb_induk_buku_kode_buku')->references('kode_buku')->on('tb_induk_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_pelanggan_id')->references('id_pelanggan')->on('tb_pelanggan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_supplier_id')->references('id_supplier')->on('tb_supplier')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_faktur_konsinyasi');
    }
}
