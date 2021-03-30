<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHistori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_histori', function (Blueprint $table) {
            $table->increments('id_histori');
            $table->char('tb_induk_buku_kode_buku', 20);
            $table->char('id_transaksi', 255);
            $table->string('entitas', 255);
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('discount')->null();
            $table->integer('harga_total');
            $table->bigInteger('stok_awal');
            $table->tinyInteger('status');
            $table->foreign('tb_induk_buku_kode_buku')->references('kode_buku')->on('tb_induk_buku')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_histori');
    }
}
