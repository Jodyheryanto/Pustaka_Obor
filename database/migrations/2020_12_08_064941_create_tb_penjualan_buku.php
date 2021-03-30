<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPenjualanBuku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_penjualan_buku', function (Blueprint $table) {
            $table->increments('id_penjualan_buku');
            $table->char('tb_induk_buku_kode_buku', 20);
            $table->integer('tb_salesman_id')->unsigned()->nullable();
            $table->integer('tb_pelanggan_id')->unsigned();
            $table->integer('qty');
            $table->integer('harga_jual_satuan');
            $table->integer('discount');
            $table->integer('harga_total');
            $table->integer('total_non_diskon');
            $table->tinyInteger('is_obral');
            $table->tinyInteger('status_penjualan');
            $table->tinyInteger('status_royalti');
            $table->foreign('tb_induk_buku_kode_buku')->references('kode_buku')->on('tb_induk_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_salesman_id')->references('id_salesman')->on('tb_salesman')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_pelanggan_id')->references('id_pelanggan')->on('tb_pelanggan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_penjualan_buku');
    }
}
