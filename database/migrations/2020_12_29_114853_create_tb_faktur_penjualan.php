<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFakturPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_faktur_penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->char('id_faktur_penjualan', 20);
            $table->tinyInteger('status_bayar');
            $table->integer('tb_penjualan_buku_id')->unsigned();
            $table->foreign('tb_penjualan_buku_id')->references('id_penjualan_buku')->on('tb_penjualan_buku')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_faktur_penjualan');
    }
}
